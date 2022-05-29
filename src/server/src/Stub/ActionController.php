<?php

declare(strict_types=1);

namespace App\Stub;

use App\Service\WebControllerService;
use App\Stub\Collection\ArrayCollection;
use App\Stub\Form\AcsRequestForm;
use App\Stub\Service\ActionFactory;
use App\Stub\Service\CallbackResolver;
use App\Stub\Service\OverrideProcessor;
use App\Stub\Session\State;
use App\Stub\Session\StateManager;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Yii\View\ViewRenderer;

final class ActionController
{
    public function __construct(
        private ViewRenderer $viewRenderer,
        private DataResponseFactoryInterface $responseFactory,
        private CallbackResolver $callbackResolver,
        private ActionFactory $actionFactory,
        private OverrideProcessor $overrideProcessor,
        private UrlGeneratorInterface $urlGenerator,
    ) {
        $this->viewRenderer = $viewRenderer
            ->withControllerName('stub/action')
            ->withLayout(null);
    }

    public function renderAcs(
        ServerRequestInterface $request,
        ValidatorInterface $validator
    ): ResponseInterface {
        $requestBody = $request->getParsedBody();
        $form = new AcsRequestForm();

        $form->load((array)$requestBody) && $validator->validate($form);

        return $this->viewRenderer->render('acsPage', ['form' => $form]);
    }

    /**
     * Accept complete request (3ds result) from Payment Page and move cursor
     *
     * @throws InvalidArgumentException
     */
    public function completeAcs(
        ServerRequestInterface $request,
        StateManager $stateManager,
    ): ResponseInterface {
        $body = json_decode($request->getBody()->getContents(), true);

        if (!$state = $stateManager->get(ArrayHelper::getValueByPath($body, 'general.payment_id'))) {
            throw new LogicException('State must be exists');
        }

        $this->completeAction($state, new ArrayCollection($body));

        $stateManager->save($state);

        return $this->responseFactory->createResponse();
    }

    public function renderAps(
        CurrentRoute $currentRoute,
    ): ResponseInterface {
        return $this->viewRenderer->render('apsPage', [
            'completeUrl' => $this->urlGenerator->generate('actions/completeAps'),
            'uniqueKey' => $currentRoute->getArgument('uniqueKey'),
        ]);
    }

    /**
     * Accept complete request from self, move cursor and redirect to Payment Page return url for rendering close iframe view
     *
     * @throws InvalidArgumentException
     */
    public function completeAps(
        ServerRequestInterface $request,
        WebControllerService $webControllerService,
        StateManager $stateManager,
    ): ResponseInterface
    {
        $body = $request->getParsedBody();

        if (!$state = $stateManager->get(ArrayHelper::getValue($body, 'uniqueKey'))) {
            throw new LogicException('State must be exists');
        }

        $this->completeAction($state, new ArrayCollection($body));

        $stateManager->save($state);

        return $webControllerService->getRedirectResponseByUrl(
            $state->getInitialRequest()->get('return_url.success')
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function completeClarification(
        ServerRequestInterface $request,
        StateManager $stateManager,
    ): ResponseInterface {
        $body = json_decode($request->getBody()->getContents(), true);

        if (!$state = $stateManager->get(ArrayHelper::getValueByPath($body, 'general.payment_id'))) {
            throw new LogicException('State must be exists');
        }

        $this->completeAction($state, new ArrayCollection($body));

        $stateManager->save($state);

        return $this->responseFactory
            ->createResponse([
                'status' => 'success',
                'request_id' => $state->getRequestId(),
                'project_id' => $state->getInitialRequest()->get('general.project_id'),
                'payment_id' => $state->getInitialRequest()->get('general.payment_id')
            ]);
    }

    private function completeAction(State $state, ArrayCollection $bodyCollection): void
    {
        $currentCallback = $this->callbackResolver->findCurrentByState($state);
        $callbackCollection = new ArrayCollection($currentCallback->getBody());

        $this->overrideProcessor->process($callbackCollection, $state);
        $action = $this->actionFactory->make($callbackCollection, $state);

        if (!$action) {
            throw new LogicException('Action must be exists');
        }

        $action->complete($bodyCollection);
    }
}
