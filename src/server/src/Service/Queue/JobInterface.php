<?php

namespace App\Service\Queue;

use Serializable;

/**
 * Some encapsulated logic to run
 * Push it to a queue {@link QueueInterface} to run it asynchronously
 */
interface JobInterface extends Serializable
{
    /**
     * Delay before run (milliseconds)
     *
     * @return int
     */
    public function getDelay(): int;

    /**
     * Some specific logic
     *
     * @return void
     */
    public function run(): void;
}
