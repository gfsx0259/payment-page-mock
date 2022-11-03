<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Service\RouteMatcher;
use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\AbstractAction;
use App\Stub\Service\Action\AcsAction;
use App\Stub\Service\Action\ApsAction;
use App\Stub\Service\Action\ClarificationAction;
use App\Stub\Service\Action\QrDataAction;
use App\Stub\Service\Action\QrImageAction;
use App\Stub\Service\ActionFactory;
use App\Stub\Session\State;
use App\Tests\UnitTester;
use Codeception\Test\Unit;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\Injector\Injector;

final class ActionFactoryTest extends Unit
{
    protected UnitTester $tester;

    private ActionFactory $actionFactory;

    private State $state;

    public function _before(): void
    {
        $this->actionFactory = $this->makeActionFactory();
        $this->state = $this->tester->makeState();
    }

    public function testAcsActionMaking(): void
    {
        $collection = new ArrayCollection(['acs' => ['pa_req' => base64_encode(json_encode(['simple 3ds 1']))]]);
        $action = $this->actionFactory->make($collection, $this->state);

        $this->assertAction(AcsAction::class, $action);
    }

    public function testClarificationActionMaking(): void
    {
        $collection = new ArrayCollection(['clarification_fields' => 'test']);
        $action = $this->actionFactory->make($collection, $this->state);

        $this->assertAction(ClarificationAction::class, $action);
    }

    public function testApsActionMaking(): void
    {
        $collection = new ArrayCollection(['return_url' => ['url' => 'test']]);
        $action = $this->actionFactory->make($collection, $this->state);

        $this->assertAction(ApsAction::class, $action);
    }

    public function testQrDataActionMaking(): void
    {
        $collection = new ArrayCollection(['display_data' => [['type' => 'qr_data']]]);
        $action = $this->actionFactory->make($collection, $this->state);

        $this->assertAction(QrDataAction::class, $action);
    }

    public function testQrImageActionMaking(): void
    {
        $collection = new ArrayCollection(['display_data' => [['type' => 'qr_img']]]);
        $action = $this->actionFactory->make($collection, $this->state);

        $this->assertAction(QrImageAction::class, $action);
    }

    public function testEmptyParamsHandling(): void
    {
        $collection = new ArrayCollection([]);
        $action = $this->actionFactory->make($collection, $this->state);

        $this->assertNull($action);
    }

    private function assertAction(string $classExpected, object $instance): void
    {
        $this->assertInstanceOf($classExpected, $instance);
        $this->assertInstanceOf(AbstractAction::class, $instance);
    }

    private function makeActionFactory(): ActionFactory
    {
        $stubs = [RouteMatcher::class => $this->make(RouteMatcher::class)];

        return $this->make(ActionFactory::class, [
            'injector' => $this->makeInjector($stubs),
            'logger' => $this->makeEmpty(LoggerInterface::class)
        ]);
    }

    private function makeInjector(array $instances = []): Injector
    {
        $container = $this->makeEmpty(
            ContainerInterface::class,
            [
                'get' => function (string $className) use ($instances) {
                    return $instances[$className];
                }
            ]
        );

        return new Injector($container);
    }
}
