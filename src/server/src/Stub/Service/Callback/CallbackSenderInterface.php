<?php

namespace App\Stub\Service\Callback;

use App\Stub\Collection\ArrayCollection;

/**
 * Sends callback to remote server
 */
interface CallbackSenderInterface
{
    public function send(string $url, ArrayCollection $callbackCollection): void;
}
