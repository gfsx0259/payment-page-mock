<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;

interface ActionInterface
{
    public function register(): bool;

    public function isCompleted(): bool;

    public function complete(ArrayCollection $completeRequest): void;
}
