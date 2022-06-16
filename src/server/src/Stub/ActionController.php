<?php

declare(strict_types=1);

namespace App\Stub;

use App\Service\WebControllerService;
use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\ActionFactory;
use App\Stub\Service\Callback\CallbackProcessor;
use App\Stub\Service\Callback\CallbackResolver;
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
        private CallbackProcessor $callbackProcessor,
        private ActionFactory $actionFactory,
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
        $callback = $this->callbackResolver->resolve($state);
        $action = $this->actionFactory->make(
            $this->callbackProcessor->process($state, $callback),
            $state
        );

        if (!$action) {
            throw new LogicException('Action must be exists');
        }

        $action->complete($bodyCollection);
    }
}
