<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Stub\Api\Service\ImageUploader;
use App\Stub\Entity\Route;
use App\Stub\Repository\RouteRepository;
use Cycle\ORM\Select\Repository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class RouteController extends EntityController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private RouteRepository $routeRepository,
        private ImageUploader $imageUploader,
    ) {
        $this->imageUploader->setUploadPath('route/');
    }

    protected function getRepository(): Repository
    {
        return $this->routeRepository;
    }

    public function index(): ResponseInterface
    {
        $routes = [];

        foreach ($this->routeRepository->findAll() as $route) {
            $routes[] = $route->toArray();
        }

        return $this->responseFactory->createResponse($routes);
    }

    /**
     * @throws Throwable
     */
    public function create(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents());

        $route = new Route(
            $data->path,
            $data->description,
            $this->imageUploader->handle($data->logo, $this->getLogoFilename($data->path)),
            (int)$data->type
        );
        $entityWriter->write([$route]);

        return $this->responseFactory
            ->createResponse(['success' => true]);
    }

    /**
     * Make logo filename from route path
     *
     * @param string $route
     * @return string
     */
    private function getLogoFilename(string $route): string
    {
        $routeParts = explode('/', $route);

        if ($routeParts > 1) {
            array_pop($routeParts);
        }

        return implode('-', $routeParts);
    }
}
