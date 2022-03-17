<?php

declare(strict_types=1);

namespace App\Stub\Controller;

use App\Stub\Entity\Callback;
use App\Stub\StubRepository;
use Neomerx\Cors\Contracts\Constants\CorsResponseHeaders;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;

final class ApiStubController
{
    private DataResponseFactoryInterface $responseFactory;
    private StubRepository $stubRepository;

    public function __construct(
        DataResponseFactoryInterface $responseFactory,
        StubRepository $stubRepository
    ) {
        $this->responseFactory = $responseFactory;
        $this->stubRepository = $stubRepository;
    }

    public function index(): ResponseInterface
    {
        $stubs = [];
        foreach ($this->stubRepository->findAll() as $stub) {
            $stubs[] = [
                'id' => $stub->getId(),
                'route' => $stub->getRoute(),
                'title' => $stub->getTitle(),
                'callbacks' => $stub->getCallbacks()->map(function (Callback $callback) {
                    return $callback->getBody();
                }),
            ];
        }

        return $this->responseFactory
            ->createResponse($stubs)
            ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*');
    }
}
