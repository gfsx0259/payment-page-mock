<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\Processor\AcsProcessor;
use App\Stub\Service\ProcessorInterface;
use Psr\Container\ContainerInterface;

class ActionProcessorFactory
{
    public function __construct(
        private ContainerInterface $container
    ) {}

    public function createProcessor(ArrayCollection $callback): ?ProcessorInterface
    {
        if ($callback->get('acs')) {
            return $this->container->get(AcsProcessor::class);
        }

        return null;
    }
}
