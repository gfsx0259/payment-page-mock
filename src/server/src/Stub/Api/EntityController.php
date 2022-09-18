<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Service\WebControllerService;
use Cycle\ORM\Select\Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

abstract class EntityController
{
    abstract protected function getRepository(): Repository;

    public function index(
        CurrentRoute $route,
        DataResponseFactoryInterface $responseFactory
    ): ResponseInterface
    {
        return $responseFactory
            ->createResponse($this->getCollection($route)->map(fn ($entity) => $entity->toArray())->getValues());

    }

    public function delete(
        CurrentRoute $route,
        EntityWriter $entityWriter,
        WebControllerService $controllerService
    ): ResponseInterface
    {
        $id = (int)$route->getArgument('id');

        if (!$entity = $this->getRepository()->findByPK($id)) {
            return $controllerService->getNotFoundResponse();
        }

        $entityWriter->delete([$entity]);

        return $controllerService->getNoContentResponse();
    }

    protected function getCollection(CurrentRoute $route): ArrayCollection
    {
        return new ArrayCollection($this->getRepository()->findAll());
    }
}
