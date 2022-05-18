<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\ProcessorInterface;
use App\Stub\Session\State;

abstract class ActionAbstractProcessor implements ProcessorInterface
{
    abstract public function getActionSigner(): ActionSignerInterface;

    public function process(ArrayCollection $callback, State $state): void
    {
        $actionKey = $this->getActionSigner()->buildActionKey($callback);

        if ($state->isActionCompleted($actionKey)) {
            $state->next();
            return;
        }

        $state->registerAction($actionKey);
    }
}
