<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\AcsAction;
use App\Stub\Session\State;
use App\Tests\UnitTester;
use Codeception\Test\Unit;

final class AcsActionTest extends Unit
{
    protected UnitTester $tester;
    private const CALLBACK = ['acs' => ['md' => 'FNj3k45K%K54$#31']];
    private const COMPLETE_REQUEST = ['md' => 'FNj3k45K%K54$#31'];

    public function testGettingActionKey(): void
    {
        $state = $this->tester->makeState();
        $action = $this->makeAction($state);
        $expectingActionKey = self::CALLBACK['acs']['md'];

        $this->tester->checkGettingActionKey($action, $expectingActionKey, self::COMPLETE_REQUEST);
    }

    public function testRegistering(): void
    {
        $state = $this->tester->makeState();
        $action = $this->makeAction($state);
        $expectingKey = self::CALLBACK['acs']['md'];

        $this->tester->checkRegistering($action, $state, $expectingKey, self::COMPLETE_REQUEST);
    }

    public function testCompleting(): void
    {
        $state = $this->tester->makeState();
        $action = $this->makeAction($state);
        $expectingKey = self::CALLBACK['acs']['md'];

        $this->tester->checkCompleting($action, $state, $expectingKey, self::COMPLETE_REQUEST);
    }

    private function makeAction(State $state): AcsAction
    {
        $collection = new ArrayCollection(self::CALLBACK);

        return new AcsAction($collection, $state);
    }
}
