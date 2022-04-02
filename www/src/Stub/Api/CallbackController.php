<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Stub\Entity\Callback;
use App\Stub\Repository\CallbackRepository;
use Neomerx\Cors\Contracts\Constants\CorsResponseHeaders;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Http\Method;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class CallbackController
{
    private DataResponseFactoryInterface $responseFactory;
    private CallbackRepository $callbackRepository;

    public function __construct(
        DataResponseFactoryInterface $responseFactory,
        CallbackRepository $callbackRepository,
    ) {
        $this->responseFactory = $responseFactory;
        $this->callbackRepository = $callbackRepository;
    }

    public function index(
        CurrentRoute $route
    ): ResponseInterface
    {
        $stubId = (int)$route->getArgument('stubId');

        $callbacks = [];
        foreach ($this->callbackRepository->findByStub($stubId) as $callback) {
            $callbacks[] = [
                'id' => $callback->getId(),
                'body' => $callback->getBody(),
            ];
        }

        return $this->responseFactory
            ->createResponse($callbacks)
            ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*');
    }

    /**
     * @throws Throwable
     */
    public function callback(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        if ($request->getMethod() === Method::OPTIONS) {
            return $this->responseFactory
                ->createResponse()
                ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*')
                ->withHeader(CorsResponseHeaders::ALLOW_HEADERS, 'Content-Type');
        }

        $data = json_decode($request->getBody()->getContents());

        if (isset($data->id)) {
            $callback = $this->callbackRepository->findByPK($data->id);
            $callback->setBody($data->callback);
        } else {
            $callback = new Callback((int)$data->stubId, json_encode($data->callback));
        }

        $entityWriter->write([$callback]);

        return $this->responseFactory
            ->createResponse($data)
            ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*');
    }
}
