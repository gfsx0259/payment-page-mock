<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Stub\Entity\Callback;
use App\Stub\Repository\CallbackRepository;
use Cycle\ORM\Select\Repository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class CallbackController extends EntityController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private CallbackRepository $callbackRepository,
    ) {}

    protected function getRepository(): Repository
    {
        return $this->callbackRepository;
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
            ->createResponse($callbacks);
    }

    /**
     * @throws Throwable
     */
    public function update(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
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
}
