<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Stub\Callback\CallbackRepository;
use Neomerx\Cors\Contracts\Constants\CorsResponseHeaders;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Http\Method;
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

    public function index(): ResponseInterface
    {
        $callbacks = [];
        foreach ($this->callbackRepository->findAll() as $stub) {
            $callbacks[] = [
                'id' => $stub->getId(),
                'body' => $stub->getBody(),
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

        $callback = $this->callbackRepository->findByPK($data->index);
        $callback->setBody($data->callback);
        $entityWriter->write([$callback]);

        return $this->responseFactory
            ->createResponse($data)
            ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*');
    }
}
