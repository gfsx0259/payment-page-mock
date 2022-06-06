<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Service\WebControllerService;
use App\Stub\Entity\Callback;
use App\Stub\Repository\CallbackRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Http\Status;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class CallbackController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private CallbackRepository $callbackRepository,
    ) {}

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
            ->createResponse($callbacks);
    }

    /**
     * @throws Throwable
     */
    public function callback(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents());

        if (isset($data->id)) {
            $callback = $this->callbackRepository->findByPK($data->id);
            $callback->setBody((array)$data->callback);
        } else {
            $callback = new Callback((int)$data->stubId, json_encode($data->callback));
        }

        $entityWriter->write([$callback]);

        return $this->responseFactory
            ->createResponse($data);
    }

    public function delete(
        CurrentRoute $route,
        EntityWriter $entityWriter,
        WebControllerService $controllerService
    ): ResponseInterface
    {
        $callbackId = (int)$route->getArgument('callbackId');

        if (!$callback = $this->callbackRepository->findByPK($callbackId)) {
            return $controllerService->getNotFoundResponse();
        }
        $entityWriter->delete([$callback]);

        return $this->responseFactory->createResponse(
            null,
            Status::NO_CONTENT
        );
    }
}
