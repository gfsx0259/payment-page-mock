<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Stub\Api\Service\ImageUploader;
use App\Stub\Entity\Route;
use App\Stub\Repository\RouteRepository;
use Neomerx\Cors\Contracts\Constants\CorsResponseHeaders;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Http\Method;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class RouteController
{
    private DataResponseFactoryInterface $responseFactory;
    private RouteRepository $routeRepository;
    private ImageUploader $imageUploader;

    public function __construct(
        DataResponseFactoryInterface $responseFactory,
        RouteRepository $stubRepository,
        ImageUploader $imageUploader,
    ) {
        $this->responseFactory = $responseFactory;
        $this->routeRepository = $stubRepository;
        $this->imageUploader = $imageUploader;
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

        $route = new Route(
            $data->title,
            $data->route,
            $this->imageUploader->handle($data->logo)
        );
        $entityWriter->write([$route]);

        return $this->responseFactory
            ->createResponse(['success' => true])
            ->withHeader(CorsResponseHeaders::ALLOW_ORIGIN, '*');
    }
}
