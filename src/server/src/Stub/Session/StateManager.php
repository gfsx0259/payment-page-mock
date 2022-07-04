<?php

namespace App\Stub\Session;

use App\Service\Queue\QueueInterface;
use App\Stub\Job\SendCallbackJob;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class StateManager
{
    public function __construct(
        private CacheInterface $cache,
        private QueueInterface $queue
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

    /**
     * @throws InvalidArgumentException
     */
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
        $oldState = $this->get($requestId);

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

        // it may be transferred to some observer
        if (!$oldState || $oldState->getCursor() !== $state->getCursor()) {
            $this->queue->push(
                SendCallbackJob::class,
                [
                    'requestId' => $requestId,
                    'delay' => 1000
                ]
            );
        }

        return true;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function link(string $key, State $state): void
    {
        $requestId = $state->getRequestId();
        $this->cache->set(
            $key,
            $requestId
        );
    }
}
