<?php

namespace App\Stub\Service\Callback;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Session\State;

interface ProcessorInterface
{
    public function process(ArrayCollection &$callback, State $state): void;
}
