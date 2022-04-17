<?php

namespace App\Stub\Service;

use App\Stub\Collection\CallbackCollection;
use App\Stub\Session\State;

interface ProcessorInterface
{
    public function process(CallbackCollection $callback, State $state): void;
}
