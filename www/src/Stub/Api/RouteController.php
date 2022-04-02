<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Stub\Repository\RouteRepository;
use Neomerx\Cors\Contracts\Constants\CorsResponseHeaders;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;

final class RouteController
{
    private DataResponseFactoryInterface $responseFactory;
    private RouteRepository $routeRepository;

    public function __construct(
        DataResponseFactoryInterface $responseFactory,
        RouteRepository $stubRepository,

    ) {
        $this->responseFactory = $responseFactory;
        $this->routeRepository = $stubRepository;
    }

    public function index(): ResponseInterface
    {
        $stubs = [];
        foreach ($this->routeRepository->findAll() as $stub) {
            $stubs[] = [
                'id' => $stub->getId(),
                'route' => $stub->getRoute(),
                'title' => $stub->getTitle(),
                'logo' => $stub->getLogo(),
            ];
        }

        return $this->responseFactory
            ->createResponse($stubs)
            ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*');
    }
}
