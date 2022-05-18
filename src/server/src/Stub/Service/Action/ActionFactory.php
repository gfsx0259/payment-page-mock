<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
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
