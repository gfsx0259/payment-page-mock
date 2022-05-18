<?php

declare(strict_types=1);

namespace App\Stub;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Form\AcsRequestForm;
use App\Stub\Repository\CallbackRepository;
use App\Stub\Service\Action\ActionProcessorFactory;
use App\Stub\Session\State;
use App\Stub\Session\StateManager;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Yii\View\ViewRenderer;

final class ActionController
{
    private ViewRenderer $viewRenderer;
    private DataResponseFactoryInterface $responseFactory;
    private CallbackRepository $callbackRepository;
    private ActionProcessorFactory $actionProcessorFactory;

    public function __construct(
        ViewRenderer $viewRenderer,
        DataResponseFactoryInterface $responseFactory,
        CallbackRepository $callbackRepository,
        ActionProcessorFactory $actionProcessorFactory,
    ) {
        $this->viewRenderer = $viewRenderer
            ->withControllerName('stub/action')
            ->withLayout(null);
        $this->responseFactory = $responseFactory;
        $this->callbackRepository = $callbackRepository;
        $this->actionProcessorFactory = $actionProcessorFactory;
    }

    public function renderAcs(
        ServerRequestInterface $request,
        ValidatorInterface $validator
    ): ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        $form = new AcsRequestForm();

        $form->load((array)$requestBody) && $validator->validate($form);

        return $this->viewRenderer->render('acsPage', ['form' => $form]);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function completeAcs(
        ServerRequestInterface $request,
        StateManager $stateManager,
    ): ResponseInterface
    {
        $body = json_decode($request->getBody()->getContents(), true);

        if (!$state = $stateManager->get(ArrayHelper::getValueByPath($body, 'general.payment_id'))) {
            throw new LogicException('State must be exists');
        }

        $this->completeAction($state, new ArrayCollection($body));

        $stateManager->save($state);

        return $this->responseFactory->createResponse();
    }

    public function clarify(
        ServerRequestInterface $request,
        StateManager $stateManager,
    ): ResponseInterface {
        $body = json_decode($request->getBody()->getContents(), true);

        if (!$state = $stateManager->get(ArrayHelper::getValueByPath($body, 'general.payment_id'))) {
            throw new LogicException('State must be exists');
        }

        $initialRequest = $state->getInitialRequest();

        $this->completeAction($state, new ArrayCollection($body));

        $stateManager->save($state);

        return $this->responseFactory
            ->createResponse([
                "status" => "success",
                "request_id" => $state->getRequestId(),
                "project_id" => $initialRequest->get('general.project_id'),
                "payment_id" => $initialRequest->get('general.payment_id')
            ]);
    }

    private function completeAction(State $state, ArrayCollection $bodyCollection)
    {
        $currentCallback = $this->callbackRepository->findCurrentOne($state);
        $callbackCollection = new ArrayCollection($currentCallback->getBody());
        $actionProcessor = $this->actionProcessorFactory->createProcessor($callbackCollection);

        if (!$actionProcessor) {
            throw new LogicException('Action processor must be exists');
        }

        $actionKey = $actionProcessor->getActionSigner()->buildActionKey($bodyCollection);

        if (!$state->isActionCompleted($actionKey)) {
            $state->completeAction($actionKey);
            $state->next();
        }
    }
}
