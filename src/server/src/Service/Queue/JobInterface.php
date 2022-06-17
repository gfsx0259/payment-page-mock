<?php

namespace App\Service\Queue;

interface JobInterface
{
    public function getDelay(): int;

    public function serialize(): string;

    public function initFromString(string $data): void;

    public function run(): void;
}
