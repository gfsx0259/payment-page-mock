<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Stub\Callback\Callback;
use App\Stub\Stub;
use App\Stub\StubRepository;
use Neomerx\Cors\Contracts\Constants\CorsResponseHeaders;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Http\Method;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class StubController
{
    private DataResponseFactoryInterface $responseFactory;
    private StubRepository $stubRepository;

    public function __construct(
        DataResponseFactoryInterface $responseFactory,
        StubRepository $stubRepository,
    ) {
        $this->responseFactory = $responseFactory;
        $this->stubRepository = $stubRepository;
    }

    public function index(
        CurrentRoute $route
    ): ResponseInterface
    {
        $routeId = (int)$route->getArgument('routeId');

        $stubs = [];
        foreach ($this->stubRepository->findByRoute($routeId) as $stub) {
            $stubs[] = [
                'id' => $stub->getId(),
                'title' => $stub->getTitle(),
                'description' => $stub->getDescription(),
                'callbacks' => $stub->getCallbacks()->map(function (Callback $callback) {
                    return [
                        'id' => $callback->getId(),
                        'body' => $callback->getBody(),
                    ];
                }),
            ];
        }

        return $this->responseFactory
            ->createResponse($stubs)
            ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*');
    }

    /**
     * @throws Throwable
     */
    public function create(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        if ($request->getMethod() === Method::OPTIONS) {
            return $this->responseFactory
                ->createResponse()
                ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*')
                ->withHeader(CorsResponseHeaders::ALLOW_HEADERS, 'Content-Type');
        }

        $data = json_decode($request->getBody()->getContents());
        $stub = new Stub(
            (int)$data->routeId,
            $data->title,
            $data->description
        );
        $entityWriter->write([$stub]);

        return $this->responseFactory
            ->createResponse(['success' => $data])
            ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*');
    }
}
