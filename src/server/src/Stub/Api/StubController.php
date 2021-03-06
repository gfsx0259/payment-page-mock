<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Service\WebControllerService;
use App\Stub\Entity\Callback;
use App\Stub\Entity\Stub;
use App\Stub\Repository\StubRepository;
use Cycle\ORM\Select\Repository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class StubController extends EntityController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private StubRepository $stubRepository,
    ) {
    }

    protected function getRepository(): Repository
    {
        return $this->stubRepository;
    }

    public function index(
        CurrentRoute $route
    ): ResponseInterface {
        $routeId = (int)$route->getArgument('routeId');

        $stubs = [];
        foreach ($this->stubRepository->findByRoute($routeId) as $stub) {
            $stubs[] = [
                'id' => $stub->getId(),
                'title' => $stub->getTitle(),
                'description' => $stub->getDescription(),
                'default' => $stub->getDefault(),
                'callbacks' => $stub->getCallbacks()->map(function (Callback $callback) {
                    return [
                        'id' => $callback->getId(),
                        'body' => $callback->getBody(),
                    ];
                }),
            ];
        }

        return $this->responseFactory
            ->createResponse($stubs);
    }

    /**
     * @throws Throwable
     */
    public function create(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents());
        $stub = new Stub(
            (int)$data->relationId,
            $data->title,
            $data->description
        );
        $entityWriter->write([$stub]);

        return $this->responseFactory
            ->createResponse(['success' => $data]);
    }

    /**
     * @throws Throwable
     */
    public function update(
        ServerRequestInterface $request,
        EntityWriter $entityWriter,
        WebControllerService $controllerService
    ): ResponseInterface {
        $data = json_decode($request->getBody()->getContents());
        $stub = $this->stubRepository->findByPK($data->id);

        if (!$stub) {
            return $controllerService->getNotFoundResponse();
        }

        $stub->setTitle($data->title);
        $stub->setDescription($data->description);

        $entityWriter->write([$stub]);

        return $this->responseFactory
            ->createResponse(['success' => $data]);
    }

    /**
     * @throws Throwable
     */
    public function setDefault(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents());
        $stubs = $this->stubRepository->findByRoute($data->routeId);

        foreach ($stubs as $stub) {
            $stub->setDefault($stub->getId() === $data->stubId);
        }

        $entityWriter->write($stubs);

        return $this->responseFactory
            ->createResponse(['success' => $data]);
    }
}
