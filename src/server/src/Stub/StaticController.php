<?php

declare(strict_types=1);

namespace App\Stub;

use App\Middleware\ResourceDataResponseFormatter;
use App\Service\WebControllerService;
use App\Stub\Entity\Resource;
use App\Stub\Repository\ResourceRepository;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Router\CurrentRoute;

final class StaticController
{
    public function render(
        CurrentRoute $currentRoute,
        ResourceRepository $resourceRepository,
        DataResponseFactoryInterface $responseFactory,
        WebControllerService $controllerService,
    ) {
        $destination = $currentRoute->getArgument('destination');
        $resource = $resourceRepository->findOne(['path' => $destination]);

        /** @var $resource Resource|null */
        if (!$resource) {
            return $controllerService->getNotFoundResponse();
        }

        return $responseFactory
            ->createResponse($resource->getContent())
            ->withResponseFormatter(new ResourceDataResponseFormatter($resource));
    }
}
