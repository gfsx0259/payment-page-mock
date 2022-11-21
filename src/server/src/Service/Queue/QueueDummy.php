<?php

namespace App\Service\Queue;

class QueueDummy implements QueueInterface
{
    public function subscribe(string $queueName, ?callable $callback = null): void {}

    public function push(string $jobClass, array $params = []): void {}

    public function checkConnection(): bool
    {
        return true;
    }
}
