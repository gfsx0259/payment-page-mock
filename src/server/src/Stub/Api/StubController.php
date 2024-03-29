<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Service\WebControllerService;
use App\Stub\Entity\Stub;
use App\Stub\Repository\RouteRepository;
use App\Stub\Repository\StubRepository;
use Cycle\ORM\Select\Repository;
use Doctrine\Common\Collections\ArrayCollection;
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

    protected function getCollection(CurrentRoute $route): ArrayCollection
    {
        return $this->routeRepository->findByPK((int)$route->getArgument('routeId'))->getStubs();
    }

    /**
     * @throws Throwable
     */
    public function create(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents());
        $stub = new Stub(
            $data->title,
            $data->description,
            $data->creator_telegram_alias,
            (array)$data->conditions,
            (int)$data->relationId,
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
        $stub->setCreatorTelegramAlias($data->creator_telegram_alias);
        $stub->setSpecification((array)$data->conditions);

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
            $stub->setIsDefault($stub->getId() === $data->stubId);
        }

        $entityWriter->write($stubs);

        return $this->responseFactory
            ->createResponse(['success' => $data]);
    }
}
