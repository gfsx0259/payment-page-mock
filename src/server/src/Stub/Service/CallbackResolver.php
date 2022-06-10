<?php

namespace App\Stub\Service;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Entity\Callback;
use App\Stub\Repository\StubRepository;
use App\Stub\Session\State;
use App\Stub\Session\StateManager;

/**
 * Resolve callback for current state:
 * * Detect current stub by route id restored from state
 * * Resolve stub callback using cursor from state
 * * Apply overrides to callback
 * * Move cursor or register action
 * * Save state instance to storage
 */
class CallbackResolver
{
    public function __construct(
        private StubRepository $stubRepository,
        private OverrideProcessor $overrideProcessor,
        private ActionFactory $actionFactory,
        private StateManager $stateManager
    ) {}

    public function resolve(State $state): ArrayCollection
    {
        $callback = $this->findCurrentByState($state);

        $callbackCollection = $this->prepareCallbackAndManageState(
            $callback,
            $state
        );

        $this->stateManager->save($state);

        return $callbackCollection;
    }

    private function findCurrentByState(State $state): Callback
    {
        $stub = $this->stubRepository->findDefaultByRoute($state->getRouteId());

        $callbacks = $stub->getCallbacks();

        $cursor = min($state->getCursor(), $callbacks->count()) - 1;

        if ($cursor < 0) {
            $cursor = 0;
        }

        return $callbacks->get($cursor);
    }

    private function prepareCallbackAndManageState(Callback $callback, State $state): ArrayCollection
    {
        $callbackCollection = new ArrayCollection($callback->getBody());

        $this->overrideProcessor->process($callbackCollection, $state);
        $action = $this->actionFactory->make($callbackCollection, $state);

        $action && !$action->isCompleted()
            ? $action->register()
            : $state->next();

        return $callbackCollection;
    }
}
