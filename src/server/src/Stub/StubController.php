<?php

declare(strict_types=1);

namespace App\Stub;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Repository\RouteRepository;
use App\Stub\Service\ActionFactory;
use App\Stub\Service\CallbackResolver;
use App\Stub\Service\OverrideProcessor;
use App\Stub\Session\State;
use App\Stub\Session\StateManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Http\Status;
use Yiisoft\Router\CurrentRoute;

final class StubController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private RouteRepository $routeRepository,
        private CallbackResolver $callbackResolver,
        private ActionFactory $actionFactory,
        private OverrideProcessor $overrideProcessor,
        private StateManager $stateManager,
    ) {}

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function status(
        ServerRequestInterface $request,
    ): ResponseInterface {
        $body = json_decode($request->getBody()->getContents());

        if (!$state = $this->stateManager->get(ArrayHelper::getValueByPath($body, 'general.payment_id'))) {
            return $this->responseNotFound();
        }

        return $this->responseByState($state);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function statusByRequest(
        ServerRequestInterface $request
    ): ResponseInterface {
        $body = json_decode($request->getBody()->getContents());

        if (!$state = $this->stateManager->get(ArrayHelper::getValueByPath($body, 'request_id'))) {
            return $this->responseNotFound();
        }

        return $this->responseByState($state);
    }

    public function sale(
        ServerRequestInterface $request,
        CurrentRoute $currentRoute
    ): ResponseInterface
    {
        if (!$route = $this->routeRepository->findByPath($currentRoute->getArgument('route'))) {
            $this->responseFactory
                ->createResponse()
                ->withStatus(Status::NOT_FOUND);
        }

        $initialRequest = json_decode($request->getBody()->getContents(), true);

        $state = new State(
            $requestId = uniqid('generated_request_id'),
            $route->getId(),
            $initialRequest
        );

       $this->stateManager->save($state);

        $responseData = [
            'status' => 'success',
            'project_id' => $state->getInitialRequest()->get('general.project_id'),
            'payment_id' => $state->getInitialRequest()->get('general.payment_id'),
            'request_id' => $requestId,
        ];

        return $this->responseFactory
            ->createResponse($responseData);
    }

    public function checkSignature(): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse();
    }

    /**
     * @param State $state
     * @return ResponseInterface
     */
    private function responseByState(State $state): ResponseInterface
    {
        $currentCallback = $this->callbackResolver->findCurrentByState($state);
        $callbackCollection = new ArrayCollection($currentCallback->getBody());

        $this->overrideProcessor->process($callbackCollection, $state);

        $action = $this->actionFactory->make($callbackCollection, $state);

        if (!$action || $action->isCompleted()) {
            $state->next();
        } else {
            $action->register();
        }

        $this->stateManager->save($state);

        return $this->responseFactory
            ->createResponse($callbackCollection->data);
    }

    private function responseNotFound(): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse([
                'payment' => ['status' => 'error'],
                'errors' => [
                    ['code' => 3061, 'message' => 'Transaction not found'],
                ],
            ]);
    }
}
