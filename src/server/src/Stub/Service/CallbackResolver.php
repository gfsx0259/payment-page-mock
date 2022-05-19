<?php

namespace App\Stub\Service;

use App\Stub\Entity\Callback;
use App\Stub\Repository\StubRepository;
use App\Stub\Session\State;

/**
 * Resolve callback for current state:
 * * Detect current stub by route id restored from state
 * * Resolve stub callback using cursor from state
 */
class CallbackResolver
{
    public function __construct(
        private StubRepository $stubRepository
    ) {}

    public function findCurrentByState(State $state): Callback
    {
        $stub = $this->stubRepository->findDefaultByRoute($state->getRouteId());

        $callbacks = $stub->getCallbacks();

        $cursor = min($state->getCursor(), $callbacks->count()) - 1;

        if ($cursor < 0) {
            $cursor = 0;
        }

        return $callbacks->get($cursor);
    }
}
