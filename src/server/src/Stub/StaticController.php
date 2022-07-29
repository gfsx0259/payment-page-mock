<?php

declare(strict_types=1);

namespace App\Stub;

use App\Middleware\JavascriptDataResponseFormatter;
use App\Stub\Repository\ResourceRepository;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Router\CurrentRoute;

final class StaticController
{
    public function render(
        CurrentRoute $currentRoute,
        ResourceRepository $resourceRepository,
        DataResponseFactoryInterface $responseFactory
    ): ResponseInterface {
        $resource = $resourceRepository->findOne(['slug' => $currentRoute->getArgument('slug')]);

        return $responseFactory->createResponse($resource->getContent())
            ->withResponseFormatter(new JavascriptDataResponseFormatter());
    }
}
