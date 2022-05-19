<?php

namespace App\Stub\Service;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\AbstractAction;
use App\Stub\Service\Action\AcsAction;
use App\Stub\Service\Action\ClarificationAction;
use App\Stub\Session\State;

class ActionFactory
{
    public function make(ArrayCollection $callback, State $state): ?AbstractAction
    {
        if ($callback->get('acs')) {
            return new AcsAction($callback, $state);
        } elseif ($callback->get('clarification_fields')) {
            return new ClarificationAction($callback, $state);
        }

        return null;
    }
}
