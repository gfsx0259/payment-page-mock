<?php

namespace App\Stub\Service\Callback;

use App\Stub\Collection\ArrayCollection;
use Psr\Log\LoggerInterface;

/**
 * Emulates sending callback
 */
class CallbackSenderMock implements CallbackSenderInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function send(string $url, ArrayCollection $callbackCollection): void
    {
        $this->logger->warning('Callback has not been sent cause `' . self::class . '` used');
    }
}
