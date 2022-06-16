<?php

namespace App\Stub\Session;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class StateManager
{
    public function __construct(
        private CacheInterface $cache
    ) {}

    /**
     * @throws InvalidArgumentException
     */
    public function get(string $key): ?State
    {
        $state = $this->cache->get($key);

        if ($state instanceof State) {
            return $state;
        } elseif ($state) {
            return $this->cache->get($state);
        } else {
            return null;
        }
    }

    public function save(State $state): bool
    {
        $requestId = $state->getRequestId();
        $paymentId = $state->getInitialRequest()->get('general.payment_id');

        try {
            $this->cache->set(
                $requestId,
                $state
            );
            $this->cache->set(
                $paymentId,
                $requestId
            );
        } catch (InvalidArgumentException) {
            return false;
        }

        return true;
    }
}
