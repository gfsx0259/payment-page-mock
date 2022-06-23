<?php

declare(strict_types=1);

namespace App\Stub;

use App\Service\WebControllerService;
use App\Stub\Collection\ArrayCollection;
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

final class ActionController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private CallbackResolver $callbackResolver,
        private ActionFactory $actionFactory,
        private OverrideProcessor $overrideProcessor,
    ) {}

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

    /**
     * Accept complete request from self, move cursor and redirect to Payment Page return url for rendering close iframe view
     *
     * @throws InvalidArgumentException
     */
    public function completeAps(
        ServerRequestInterface $request,
        WebControllerService $webControllerService,
        StateManager $stateManager,
    ): ResponseInterface {
        $state = $this->completeAction($request, $stateManager, 'uniqueKey');

        return $webControllerService->getRedirectResponseByUrl(
            $state->getInitialRequest()->get('return_url.success')
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function completeConfirmationViaQrCode(
        ServerRequestInterface $request,
        WebControllerService $webControllerService,
        StateManager $stateManager,
    ): ResponseInterface {
        $state = $this->completeAction($request, $stateManager, 'uniqueKey');

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
        $state = $this->completeAction($request, $stateManager, 'general.payment_id');

        return $this->responseFactory
            ->createResponse([
                'status' => 'success',
                'request_id' => $state->getRequestId(),
                'project_id' => $state->getInitialRequest()->get('general.project_id'),
                'payment_id' => $state->getInitialRequest()->get('general.payment_id')
            ]);
    }

    private function completeAction(
        ServerRequestInterface $request,
        StateManager $stateManager,
        string $identityKeyName
    ): State {
        $body = json_decode($request->getBody()->getContents(), true);

        if (!$state = $stateManager->get(ArrayHelper::getValueByPath($body, $identityKeyName))) {
            throw new LogicException('State must be exists');
        }

        $currentCallback = $this->callbackResolver->findCurrentByState($state);
        $callbackCollection = new ArrayCollection($currentCallback->getBody());

        $this->overrideProcessor->process($callbackCollection, $state);
        $action = $this->actionFactory->make($callbackCollection, $state);

        if (!$action) {
            throw new LogicException('Action must be exists');
        }

        $action->complete($body);
        $stateManager->save($state);

        return $state;
    }
}
