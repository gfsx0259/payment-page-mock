<?php

namespace App\Service;

use App\Command\Fixture\Dto\ResourceDto;
use App\Command\Fixture\Dto\RouteDto;
use App\Stub\Entity\Callback;
use App\Stub\Entity\Resource;
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
    private array $resources = [];

    /**
     * @param RouteDto[] $routeDefinitions
     * @param ResourceDto[] $resourceDefinitions
     * @param EntityManagerInterface $entityManager
     * @param Aliases $aliases
     */
    public function __construct(
        private array $routeDefinitions,
        private array $resourceDefinitions,
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

        foreach ($this->resourceDefinitions as $resourceDefinition) {
            $this->resources[] = $this->processResourceDefinition($resourceDefinition);
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
                $callbackBody = $this->readFile($this->aliases->get('@fixture/callbacks/' . $callbackPath . '.json'));

                $stub->addCallback(new Callback($callbackBody, $index));
            }

            $stub->setDefault($scenario->isDefault);

            $route->addStubs($stub);
        }

        return $route;
    }

    private function processResourceDefinition(ResourceDto $definition): Resource
    {
        return new Resource(
            $definition->path,
            $definition->alias,
            $definition->description,
            $definition->contentType,
            $this->readFile($this->aliases->get('@fixture/resources/' . $definition->contentPath)),
        );
    }

    /**
     * @throws Throwable
     */
    private function saveEntities(): void
    {
        (new EntityWriter($this->entityManager))->write($this->routes);
        (new EntityWriter($this->entityManager))->write($this->resources);
    }

    /**
     * @throws FilesystemException
     */
    private function readFile(string $path): string
    {
        return \Safe\file_get_contents($path);
    }
}
