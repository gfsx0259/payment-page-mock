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
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class RouteController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private RouteRepository $routeRepository,
        private ImageUploader $imageUploader,
    ) {}

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
        $data = json_decode($request->getBody()->getContents());

        $route = new Route(
            $data->title,
            $data->route,
            $this->imageUploader->handle($data->logo)
        );
        $entityWriter->write([$route]);

        return $this->responseFactory
            ->createResponse(['success' => true]);
    }
}
