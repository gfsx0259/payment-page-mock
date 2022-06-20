<?php

namespace App\Service\Queue;

/**
 * Helps to process jobs asynchronously
 */
interface QueueInterface
{
    /**
     * Starts listening jobs from remote server
     *
     * @param string $queueName
     * @param callable|null $callback
     * @return void
     */
    public function subscribe(string $queueName, ?callable $callback = null): void;

    /**
     * Sends job to remote server
     *
     * @param string $jobClass
     * @param array $params
     * @return void
     */
    public function push(string $jobClass, array $params = []): void;
}
