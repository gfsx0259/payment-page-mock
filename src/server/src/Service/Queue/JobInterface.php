<?php

namespace App\Service\Queue;

/**
 * Some encapsulated logic to run
 * Push it to a queue {@link QueueInterface} to run it asynchronously
 */
interface JobInterface
{
    /**
     * Delay before run (milliseconds)
     *
     * @return int
     */
    public function getDelay(): int;

    /**
     * Converts inside data to string
     *
     * @return string
     */
    public function serialize(): string;

    /**
     * Parse data from the string made by method {@link serialize()} to fill the object
     *
     * @param string $data
     * @return void
     */
    public function initFromString(string $data): void;

    /**
     * Some specific logic
     *
     * @return void
     */
    public function run(): void;
}
