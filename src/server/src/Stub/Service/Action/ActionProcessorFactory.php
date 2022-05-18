<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\Processor\AcsProcessor;
use App\Stub\Service\Action\Processor\ClarificationProcessor;
use Psr\Container\ContainerInterface;

class ActionProcessorFactory
{
    public function __construct(
        private ContainerInterface $container
    ) {}

    public function createProcessor(ArrayCollection $callback): ?ActionAbstractProcessor
    {
        if ($callback->get('acs')) {
            return $this->container->get(AcsProcessor::class);
        } elseif ($callback->get('clarification_fields')) {
            return $this->container->get(ClarificationProcessor::class);
        }

        return null;
    }
}
