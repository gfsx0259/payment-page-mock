<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Service\WebControllerService;
use App\Stub\Entity\Stub;
use App\Stub\Repository\RouteRepository;
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
        private RouteRepository $routeRepository,
    ) {}

    protected function getRepository(): Repository
    {
        return $this->stubRepository;
    }

    public function index(
        CurrentRoute $route
    ): ResponseInterface {
        $route = $this->routeRepository->findByPK((int)$route->getArgument('routeId'));

        return $this->responseFactory
            ->createResponse($route->getStubs()->map(fn ($callback) => $callback->toArray())->getValues());
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
        $route = $this->routeRepository->findByPK($data->routeId);
        $stubs = $route->getStubs();

        foreach ($stubs as $stub) {
            $stub->setDefault($stub->getId() === $data->stubId);
        }

        $entityWriter->write($stubs);

        return $this->responseFactory
            ->createResponse(['success' => $data]);
    }
}
