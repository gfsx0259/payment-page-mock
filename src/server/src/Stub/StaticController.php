<?php

declare(strict_types=1);

namespace App\Stub;

use App\Middleware\ResourceDataResponseFormatter;
use App\Service\WebControllerService;
use App\Stub\Entity\Resource;
use App\Stub\Repository\ResourceRepository;
use App\Stub\Service\Specification\SpecificationEntityCollectionException;
use App\Stub\Service\Specification\SpecificationEntityCollectionResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Router\CurrentRoute;

final class StaticController
{
    public function render(
        CurrentRoute $currentRoute,
        ResourceRepository $resourceRepository,
        DataResponseFactoryInterface $responseFactory,
        WebControllerService $controllerService,
        ServerRequestInterface $serverRequest,
        SpecificationEntityCollectionResolver $entityCollectionResolver,
    ): ResponseInterface {
        $requestData = json_decode($serverRequest->getBody()->getContents(), true);
        $destination = $currentRoute->getArgument('destination');

        $resources = $resourceRepository->findByPath($destination);

        /** @var $resource Resource|null */
        if (!$resources) {
            return $controllerService->getNotFoundResponse();
        }

        try {
            $resource = $entityCollectionResolver->resolveMostPriority($requestData ?? [], $resources);
        } catch (SpecificationEntityCollectionException) {
            return $controllerService->getNotFoundResponse();
        }

        return $responseFactory
            ->createResponse($resource->getContent())
            ->withResponseFormatter(new ResourceDataResponseFormatter($resource));
    }
}
