<?php

namespace App\Stub\Service\Callback;

use App\Stub\Service\Action\AbstractAction;
use App\Stub\Collection\ArrayCollection;
use App\Stub\Entity\Callback;
use App\Stub\Service\ActionFactory;
use App\Stub\Session\State;
use App\Stub\Session\StateManager;

/**
 * Process callback entity:
 * * Apply overrides to callback
 * * Move cursor or register action
 * * Save state instance to storage
 */
class CallbackProcessor
{
    public function __construct(
        private OverrideProcessor $overrideProcessor,
        private ActionFactory $actionFactory,
        private StateManager $stateManager,
    ) {}

    public function process(State $state, Callback $callback): ArrayCollection
    {
        $collection = new ArrayCollection($callback->getBody());

        $this->overrideProcessor->process($collection, $state);

        if ($action = $this->actionFactory->make($collection, $state)) {
            $this->applyAction($action, $state);
        } else {
            $state->next();
        }

        $this->stateManager->save($state);

        return $collection;
    }

    private function applyAction(AbstractAction $action, State $state): void
    {
        $action->isCompleted()
            ? $state->next()
            : $action->register();
    }
}
