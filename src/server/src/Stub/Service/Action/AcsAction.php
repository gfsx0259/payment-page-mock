<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\ActionException;

/**
 * Implements redirect logic by processing passed callback:
 * - at begin, set flag indicated that mock is waiting for redirect completion {@see State::registerAction()}
 * - further, checks if flag was changed {@see State::isActionCompleted()}
 *
 * Uses merchant data (acs.md) for action matching.
 */
class AcsAction extends AbstractAction
{
    public function getActionKey(?ArrayCollection $completeRequest = null): string
    {
        if ($completeRequest === null) {
            return $this->callback->get('acs.md');
        }

        if ($completeRequest->get('md')) {
            return $completeRequest->get('md');
        }

        throw new ActionException('Can not find md field');
    }
}
