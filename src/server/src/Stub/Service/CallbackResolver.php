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
        private StubRepository $stubRepository,
    ) {}

    public function resolve(State $state): Callback
    {
        $stub = $this->stubRepository->findDefaultByRoute($state->getRouteId());

        $callbacks = $stub->getCallbacks();

        $callback = $callbacks->get($state->getCursor());

        if (!$callback) {
            return $callbacks->last();
        }

        return $callback;
    }
}
