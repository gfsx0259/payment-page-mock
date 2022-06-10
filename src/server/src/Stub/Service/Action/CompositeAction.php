<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;

class CompositeAction implements ActionInterface
{
    /**
     * @param ActionInterface[] $actions
     */
    public function __construct(
        private array $actions
    ) {
    }

    public function register(): bool
    {
        $hasRegistrations = false;

        foreach ($this->actions as $action) {
            $hasRegistrations = $hasRegistrations || $action->register();
        }

        return $hasRegistrations;
    }

    public function isCompleted(): bool
    {
        $allCompleted = true;

        foreach ($this->actions as $action) {
            $allCompleted = $allCompleted && $action->isCompleted();
        }

        return $allCompleted;
    }

    public function complete(ArrayCollection $completeRequest): void
    {
        foreach ($this->actions as $action) {
            $action->complete($completeRequest);
        }
    }
}
