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
        $stubs = [];
        foreach ($this->routeRepository->findAll() as $stub) {
            $stubs[] = [
                'id' => $stub->getId(),
                'route' => $stub->getRoute(),
                'title' => $stub->getTitle(),
                'logo' => $stub->getLogo(),
                'type' => $stub->getType(),
            ];
        }

        return $this->responseFactory
            ->createResponse($stubs);
    }

    /**
     * @throws Throwable
     */
    public function create(ServerRequestInterface $request, EntityWriter $entityWriter): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents());

        $route = new Route(
            $data->route,
            $data->title,
            $this->imageUploader->handle($data->logo, $this->getLogoFilename($data->route)),
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
