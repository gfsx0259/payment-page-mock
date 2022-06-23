<?php

namespace App\Stub\Session;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class StateManager
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

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

    public function generateAccessKey(State $state): string
    {
        $uniqueKey = md5($state->getRequestId() . $state->getCursor());

        $this->link($uniqueKey, $state);

        return $uniqueKey;
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

    private function link(string $key, State $state): bool
    {
        $requestId = $state->getRequestId();

        try {
            $this->cache->set(
                $key,
                $requestId
            );
        } catch (InvalidArgumentException) {
            return false;
        }

        return true;
    }
}
