<?php

namespace App\Service\Queue;

interface QueueInterface
{
    public function subscribe(string $queueName, ?callable $callback = null): void;

    public function send(string $jobClass, array $params = []): void;
}
