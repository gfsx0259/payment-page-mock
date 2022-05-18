<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;

interface ActionSignerInterface
{
    /**
     * Builds a unique key of action to store in state
     *
     * @param ArrayCollection $data
     * @return string
     */
    public function buildActionKey(ArrayCollection $data): string;
}
