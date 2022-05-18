<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Session\State;

abstract class AbstractAction
{
    /**
     * @param ArrayCollection $callback
     * @param State $state
     * @return void
     */
    public function __construct(
        protected ArrayCollection $callback,
        protected State $state
    ) {
        if (!$this->isCompleted()) {
            $actionKey = $this->getActionKey();

            $this->state->registerAction($actionKey);
        }
    }

    /**
     * @param ArrayCollection|null $data
     * @return string
     */
    abstract public function getActionKey(?ArrayCollection $data = null): string;

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        $actionKey = $this->getActionKey();

        return $this->state->isActionCompleted($actionKey);
    }

    /**
     * @param ArrayCollection $data
     * @return void
     */
    public function complete(ArrayCollection $data): void
    {
        $actionKey = $this->getActionKey($data);

        if (!$this->state->isActionCompleted($actionKey)) {
            $this->state->completeAction($actionKey);
            $this->state->next();
        }
    }
}
