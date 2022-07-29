<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\PaymentAction;
use App\Stub\Session\State;
use App\Tests\UnitTester;
use Codeception\Test\Unit;

final class PaymentActionTest extends Unit
{
    protected UnitTester $tester;
    private const INITIAL_REQUEST = ['general' => ['payment_id' => 'FNj3k45K%K54$#31']];
    private const COMPLETE_REQUEST = ['general' => ['payment_id' => 'FNj3k45K%K54$#31']];

    public function testGettingActionKey(): void
    {
        $state = $this->tester->makeState(self::INITIAL_REQUEST);
        $action = $this->makeAction($state);
        $expectingKey = md5(
            PaymentAction::class . $state->getCursor() . self::INITIAL_REQUEST['general']['payment_id']
        );

        $this->tester->checkGettingActionKey($action, $expectingKey, self::COMPLETE_REQUEST);
    }

    public function testRegistering(): void
    {
        $state = $this->tester->makeState(self::INITIAL_REQUEST);
        $action = $this->makeAction($state);
        $expectingKey = md5(
            PaymentAction::class . $state->getCursor() . self::INITIAL_REQUEST['general']['payment_id']
        );

        $this->tester->checkRegistering($action, $state, $expectingKey, self::COMPLETE_REQUEST);
    }

    public function testCompleting(): void
    {
        $state = $this->tester->makeState(self::INITIAL_REQUEST);
        $action = $this->makeAction($state);
        $expectingKey = md5(
            PaymentAction::class . $state->getCursor() . self::INITIAL_REQUEST['general']['payment_id']
        );

        $this->tester->checkCompleting($action, $state, $expectingKey, self::COMPLETE_REQUEST);
    }

    private function makeAction(State $state): PaymentAction
    {
        $collection = new ArrayCollection([]);

        return new PaymentAction($collection, $state);
    }
}
