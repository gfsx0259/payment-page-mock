<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\ActionException;
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
            $this->state->registerAction($this->getActionKey());
        }
    }

    /**
     * @param ArrayCollection|null $completeRequest
     * @return string
     * @throws ActionException
     */
    abstract public function getActionKey(?ArrayCollection $completeRequest = null): string;

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->state->isActionCompleted($this->getActionKey());
    }

    /**
     * @param ArrayCollection $completeRequest
     * @return void
     */
    public function complete(ArrayCollection $completeRequest): void
    {
        $actionKey = $this->getActionKey($completeRequest);

        if (!$this->state->isActionCompleted($actionKey)) {
            $this->state->completeAction($actionKey);
            $this->state->next();
        }
    }
}
