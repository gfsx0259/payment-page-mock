<?php

namespace App\Service;

use App\Command\Fixture\Dto\RouteDto;
use App\Stub\Entity\Callback;
use App\Stub\Entity\Route;
use App\Stub\Entity\Stub;
use Cycle\ORM\EntityManagerInterface;
use Safe\Exceptions\FilesystemException;
use Throwable;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

final class DataLoader
{
    private array $routes = [];

    public function __construct(
        private array $routeDefinitions,
        private EntityManagerInterface $entityManager,
        private Aliases $aliases,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function load(): void
    {
        foreach ($this->routeDefinitions as $routeDefinition) {
            $this->routes[] = $this->processRouteDefinition($routeDefinition);
        }

        $this->saveEntities();
    }

    /**
     * @throws FilesystemException
     */
    private function processRouteDefinition(RouteDto $definition): Route
    {
        $route = new Route(
            $definition->route,
            $definition->description,
            $definition->logo,
            $definition->type,
        );

        foreach ($definition->scenarios as $scenario) {
            $stub = new Stub(
                $scenario->title,
                $scenario->description,
                $scenario->telegramAlias
            );

            foreach ($scenario->callbacks as $index => $callbackPath) {
                $callbackBody = $this->readCallback($this->aliases->get('@fixture/callbacks/' . $callbackPath . '.json'));

                $stub->addCallback(new Callback($callbackBody, $index));
            }

            $stub->setDefault($scenario->isDefault);

            $route->addStubs($stub);
        }

        return $route;
    }

    /**
     * @throws Throwable
     */
    private function saveEntities(): void
    {
        (new EntityWriter($this->entityManager))->write($this->routes);
    }

    /**
     * @throws FilesystemException
     */
    private function readCallback(string $path): string
    {
        return \Safe\file_get_contents($path);
    }
}
