<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Entity\Callback;
use App\Stub\Service\Action\AbstractAction;
use App\Stub\Service\ActionFactory;
use App\Stub\Service\Callback\CallbackProcessor;
use App\Stub\Service\Callback\CallbackResolver;
use App\Stub\Service\Callback\OverrideProcessor;
use App\Stub\Session\State;
use App\Stub\Session\StateManager;
use App\Tests\UnitTester;
use Codeception\Test\Unit;

final class CallbackProcessorTest extends Unit
{
    protected UnitTester $tester;

    private const CALLBACK = ['some_test_key' => 'some_test_value'];

    private const TEST_ACTION_KEY = 'fdsafdsa';

    public function testProcessWithoutAction(): void
    {
        $state = $this->tester->makeState();
        $cursor = $state->getCursor();
        $callback = new Callback(1, json_encode(self::CALLBACK));

        $overridingApplied = false;
        $stateCursorSwitched = false;

        $callbackProcessor = $this->makeCallbackProcess(
            function (ArrayCollection $collection, State $state) {
                $collection->set('overriding', $state->getRequestId());
                return $collection;
            },
            function (ArrayCollection $collection, State $state) use (&$overridingApplied) {
                $overridingApplied = $collection->get('overriding') === $state->getRequestId();
            },
            function (State $state) use (&$stateCursorSwitched, $cursor) {
                $stateCursorSwitched = $state->getCursor() === $cursor + 1;

                return true;
            },
            function (State $state) {
                return 2;
            }
        );

        $callbackProcessor->process($state, $callback);

        $this->assertTrue($overridingApplied, 'OverrideProcessor has not been applied before ActionFactory called');
        $this->assertTrue($stateCursorSwitched, 'State cursor has not been switched');

        $callbackProcessor->process($state, $callback);

        $this->assertEquals(
            $cursor + 1,
            $state->getCursor(),
            'State cursor is greater than possible count of callbacks'
        );
    }

    public function testProcessWithUncompletedAction(): void
    {
        $state = $this->tester->makeState();
        $cursor = $state->getCursor();
        $callback = new Callback(1, json_encode(self::CALLBACK));

        $overridingApplied = false;
        $actionRegistered = false;
        $stateCursorSwitched = false;

        $stubAction = $this->makeEmpty(AbstractAction::class, [
            'isCompleted' => function () {
                return false;
            },
            'register' => function () use (&$state) {
                $state->registerAction(self::TEST_ACTION_KEY);

                return true;
            },
        ]);

        $callbackProcessor = $this->makeCallbackProcess(
            function (ArrayCollection $collection, State $state) {
                $collection->set('overriding', $state->getRequestId());
                return $collection;
            },
            function (ArrayCollection $collection, State $state) use (&$overridingApplied, $stubAction) {
                $overridingApplied = $collection->get('overriding') === $state->getRequestId();

                return $stubAction;
            },
            function (State $state) use (&$actionRegistered, &$stateCursorSwitched, $cursor) {
                $actionRegistered = $state->isActionRegistered(self::TEST_ACTION_KEY);
                $stateCursorSwitched = $state->getCursor() === $cursor + 1;

                return true;
            },
            function (State $state) {
                return 2;
            }
        );

        $callbackProcessor->process($state, $callback);

        $this->assertTrue($overridingApplied, 'OverrideProcessor has not been applied before ActionFactory called');
        $this->assertTrue($actionRegistered, 'Action has not been registered');
        $this->assertFalse($stateCursorSwitched, 'State cursor has been switched');
    }

    public function testProcessWithCompletedAction(): void
    {
        $state = $this->tester->makeState();
        $cursor = $state->getCursor();
        $callback = new Callback(1, json_encode(self::CALLBACK));

        $overridingApplied = false;
        $stateCursorSwitched = false;

        $stubAction = $this->makeEmpty(AbstractAction::class, [
            'isCompleted' => function () {
                return true;
            },
        ]);

        $callbackProcessor = new CallbackProcessor(
            $this->make(OverrideProcessor::class, [
                'process' => function (ArrayCollection $collection, State $state) {
                    $collection->set('overriding', $state->getRequestId());
                    return $collection;
                }
            ]),
            $this->make(ActionFactory::class, [
                'make' => function (ArrayCollection $collection, State $state) use (&$overridingApplied, $stubAction) {
                    $overridingApplied = $collection->get('overriding') === $state->getRequestId();

                    return $stubAction;
                }
            ]),
            $this->make(StateManager::class, [
                'save' => function (State $state) use (&$stateCursorSwitched, $cursor) {
                    $stateCursorSwitched = $state->getCursor() === $cursor + 1;

                    return true;
                }
            ]),
            $this->make(CallbackResolver::class, [
                'getCallbacksCount' => function (State $state) {
                    return 2;
                }
            ]),
        );

        $callbackProcessor->process($state, $callback);

        $this->assertTrue($overridingApplied, 'OverrideProcessor has not been applied before ActionFactory called');
        $this->assertTrue($stateCursorSwitched, 'State cursor has been switched');

        $callbackProcessor->process($state, $callback);

        $this->assertEquals(
            $cursor + 1,
            $state->getCursor(),
            'State cursor is greater than possible count of callbacks'
        );
    }

    private function makeCallbackProcess(
        callable $overrideProcess,
        callable $makeAction,
        callable $saveState,
        callable $getCallbacksCount
    ): CallbackProcessor {
        return new CallbackProcessor(
            $this->make(OverrideProcessor::class, ['process' => $overrideProcess]),
            $this->make(ActionFactory::class, ['make' => $makeAction]),
            $this->make(StateManager::class, ['save' => $saveState]),
            $this->make(CallbackResolver::class, ['getCallbacksCount' => $getCallbacksCount]),
        );
    }
}
