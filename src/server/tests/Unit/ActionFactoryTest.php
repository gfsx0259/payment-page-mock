<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\AbstractAction;
use App\Stub\Service\Action\AcsAction;
use App\Stub\Service\Action\ClarificationAction;
use App\Stub\Service\ActionFactory;
use App\Stub\Session\State;
use App\Tests\UnitTester;
use Codeception\Test\Unit;

final class ActionFactoryTest extends Unit
{
    protected UnitTester $tester;

    private ActionFactory $actionFactory;

    private State $state;

    public function _before(): void
    {
        $this->actionFactory = $this->make(ActionFactory::class);
        $this->state = $this->tester->makeState();
    }

    public function testAcsActionMaking(): void
    {
        $collection = new ArrayCollection(['acs' => 'test']);
        $action = $this->actionFactory->make($collection, $this->state);

        $this->assertAction(AcsAction::class, $action);
    }

    public function testClarificationActionMaking(): void
    {
        $collection = new ArrayCollection(['clarification_fields' => 'test']);
        $action = $this->actionFactory->make($collection, $this->state);

        $this->assertAction(ClarificationAction::class, $action);
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
}
