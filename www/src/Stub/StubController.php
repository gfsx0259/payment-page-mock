<?php

declare(strict_types=1);

namespace App\Stub;

use App\Stub\Session\State;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\DataResponse\DataResponseFactoryInterface;

final class StubController
{
    private DataResponseFactoryInterface $responseFactory;
    private CacheInterface $cache;
    private RouteRepository $stubRepository;

    public function __construct(
        DataResponseFactoryInterface $responseFactory,
        CacheInterface $cache,
        RouteRepository $routeRepository
    ) {
        $this->responseFactory = $responseFactory;
        $this->cache = $cache;
        $this->stubRepository = $routeRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function status(
        ServerRequestInterface $request,
    ): ResponseInterface {
        $body = json_decode($request->getBody()->getContents());

        if (!$state = $this->getState(ArrayHelper::getValueByPath($body, 'general.payment_id'))) {
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

        if (!$state = $this->getState(ArrayHelper::getValueByPath($body, 'request_id'))) {
            return $this->responseNotFound();
        }

        return $this->responseByState($state);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function sale(ServerRequestInterface $request): ResponseInterface
    {
        $body = json_decode($request->getBody()->getContents());

        $paymentId = ArrayHelper::getValueByPath($body, 'general.payment_id');
        $projectId = ArrayHelper::getValueByPath($body, 'general.project_id');
        $requestId = uniqid('generated_request_id');

        $this->cache->set(
            $requestId,
            new State(
                $requestId,
                str_replace('/en', '', $request->getUri()->getPath())
            )
        );
        $this->cache->set(
            $paymentId,
            $requestId
        );

        $responseData = [
            'status' => 'success',
            'project_id' => $projectId,
            'payment_id' => $paymentId,
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
     * @throws InvalidArgumentException
     */
    private function getState(string $key): ?State
    {
        $state = $this->cache->get($key);

        if ($state instanceof State) {
            return $state;
        } elseif ($state) {
            return $this->cache->get($state);
        } else {
            return null;
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private function responseByState(State $state): ResponseInterface
    {
        $stub = $this->stubRepository->findOne([
            'route'=> $state->getRoute()
        ]);

        $callbacks = $stub->getCallbacks();
        $callbackIndex = max(0, min($state->getCount(), $callbacks->count()) - 1);

        $this->cache->set(
            $state->getRequestId(),
            $state->increaseCount()
        );

        return $this->responseFactory
            ->createResponse($callbacks->get($callbackIndex)->getBody());
    }

    private function responseNotFound(): ResponseInterface
    {
        $responseData = [
            'payment' => [
                'status' => 'error',
            ],
            'errors' => [
                [
                    'code' => 3061,
                    'message' => 'Transaction not found',
                ],
            ],
        ];

        return $this->responseFactory
            ->createResponse($responseData);
    }
}
