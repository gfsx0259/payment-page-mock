<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\AbstractAction;
use App\Stub\Service\ActionException;
use App\Stub\Session\State;
use Exception;

class Action extends \Codeception\Module
{
    public function checkGettingActionKey(AbstractAction $action, string $expectingKey, array $completeRequest): void
    {
        $completeRequestCollection = new ArrayCollection($completeRequest);
        $exception = null;

        try {
            $emptyCollection = new ArrayCollection([]);

            $action->getActionKey($emptyCollection);
        } catch (Exception $thrown) {
            $exception = $thrown;
        }

        $this->assertEquals($expectingKey, $action->getActionKey());
        $this->assertEquals($expectingKey, $action->getActionKey($completeRequestCollection));
        $this->assertInstanceOf(ActionException::class, $exception);
    }

    public function checkRegistering(
        AbstractAction $action,
        State $state,
        string $expectingKey,
        array $completeRequest
    ): void {
        $completeRequestCollection = new ArrayCollection($completeRequest);

        $this->assertFalse($state->isActionRegistered($expectingKey));
        $this->assertTrue($action->register());
        $this->assertTrue($state->isActionRegistered($expectingKey));

        $action->complete($completeRequestCollection);

        $this->assertFalse($action->register());
        $this->assertTrue($state->isActionRegistered($expectingKey));
    }

    public function checkCompleting(
        AbstractAction $action,
        State $state,
        string $expectingKey,
        array $completeRequest
    ): void {
        $completeRequestCollection = new ArrayCollection($completeRequest);
        $initialCursor = $state->getCursor();

        $this->assertFalse($state->isActionCompleted($expectingKey));
        $this->assertFalse($action->isCompleted());

        $action->complete($completeRequestCollection);

        $this->assertEquals($initialCursor + 1, $state->getCursor());
        $this->assertTrue($state->isActionCompleted($expectingKey));
        $this->assertTrue($action->isCompleted());
    }

    public function makeState(): State
    {
        return new State(
            uniqid('generated_request_id'),
            rand(1, 1000000),
            []
        );
    }
}
