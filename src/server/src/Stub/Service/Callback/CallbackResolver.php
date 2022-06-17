<?php

namespace App\Stub\Service\Callback;

use Doctrine\Common\Collections\ArrayCollection;
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
    ) {
    }

    public function resolve(State $state): Callback
    {
        $callbacks = $this->getCallbacks($state);
        $callback = $callbacks->get($state->getCursor());

        return $callback
            ?: $callbacks->last();
    }

    public function getCallbacksCount(State $state): int
    {
        return count($this->getCallbacks($state));
    }

    private function getCallbacks(State $state): ArrayCollection
    {
        $stub = $this->stubRepository->findDefaultByRoute($state->getRouteId());

        return $stub->getCallbacks();
    }
}
