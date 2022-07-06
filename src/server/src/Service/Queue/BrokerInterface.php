<?php

namespace App\Service\Queue;

/**
 * Works with some remote server to send/receive text messages
 */
interface BrokerInterface
{
    public function send(string $queueName, string $message, array $options = []): void;

    public function listen(string $queueName, callable $messageHandler): void;

    public function checkConnection(): bool;
}
