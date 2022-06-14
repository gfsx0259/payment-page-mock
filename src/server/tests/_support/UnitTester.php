<?php

declare(strict_types=1);

namespace App\Tests;

use Psr\Container\ContainerInterface;
use Yiisoft\Config\Config;
use Yiisoft\Config\ConfigInterface;
use Yiisoft\Config\ConfigPaths;
use Yiisoft\Config\Modifier\RecursiveMerge;
use Yiisoft\Config\Modifier\RemoveFromVendor;
use Yiisoft\Config\Modifier\ReverseMerge;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class UnitTester extends \Codeception\Actor
{
    private ContainerInterface $container;

    use _generated\UnitTesterActions;

    public function makeByAppContainer(string $className)
    {
        if (!isset($this->container)) {
            // TODO need to make test environment in application to use here
            $appRootPath = __DIR__ . '/../..';
            $config = $this->makeConfig(new ConfigPaths($appRootPath, 'config'), '');
            $this->container = $this->createDefaultContainer($config);
        }

        return $this->container->get($className);
    }

    private function makeConfig(ConfigPaths $paths, ?string $environment): Config
    {
        $eventGroups = [
            'events',
            'events-web',
            'events-console',
        ];

        return new Config(
            $paths,
            $environment,
            [
                ReverseMerge::groups(...$eventGroups),
                RecursiveMerge::groups('params', ...$eventGroups),
            ],
        );
    }

    private function createDefaultContainer(ConfigInterface $config): Container
    {
        $definitionEnvironment = 'web';
        $containerConfig = ContainerConfig::create()->withValidate(false);

        if ($config->has($definitionEnvironment)) {
            $containerConfig = $containerConfig->withDefinitions($config->get($definitionEnvironment));
        }

        if ($config->has("providers-$definitionEnvironment")) {
            $containerConfig = $containerConfig->withProviders($config->get("providers-$definitionEnvironment"));
        }

        if ($config->has("delegates-$definitionEnvironment")) {
            $containerConfig = $containerConfig->withDelegates($config->get("delegates-$definitionEnvironment"));
        }

        return new Container($containerConfig);
    }
}
