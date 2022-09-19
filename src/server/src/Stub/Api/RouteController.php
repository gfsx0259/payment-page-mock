<?php

declare(strict_types=1);

namespace App\Stub\Api;

use App\Service\WebControllerService;
use App\Stub\Api\Form\RouteForm;
use App\Stub\Api\Service\RouteService;
use App\Stub\Entity\Route;
use App\Stub\Repository\RouteRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\Arrays\ArrayHelper;

final class RouteController extends EntityController
{
    public function __construct(
        private WebControllerService $controllerService,
        private RouteService $routeService,
        private RouteRepository $routeRepository,
    ) {}

    protected function getRepository(): RouteRepository
    {
        return $this->routeRepository;
    }

    /**
     * @throws Throwable
     */
    public function create(ServerRequestInterface $request): ResponseInterface
    {
        $form = new RouteForm();
        $form->load($request->getParsedBody());

        $this->routeService->save(
            new Route(),
            $form
        );

        return $this->controllerService->getEmptySuccessResponse();
    }

    /**
     * @throws Throwable
     */
    public function update(ServerRequestInterface $request): ResponseInterface
    {
        $form = new RouteForm();
        $form->load($request->getParsedBody());

        if (!$route = $this->routeRepository->findByPK(ArrayHelper::getValue($request->getParsedBody(), 'id'))) {
            return $this->controllerService->getNotFoundResponse();
        }

        $this->routeService->save(
            $route,
            $form
        );

        return $this->controllerService->getEmptySuccessResponse();
    }
}
