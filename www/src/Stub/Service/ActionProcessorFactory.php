<?php

namespace App\Stub\Service;

use App\Stub\Collection\CallbackCollection;
use App\Stub\Service\Processor\AcsProcessor;
use Psr\Container\ContainerInterface;

class ActionProcessorFactory
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createProcessor(CallbackCollection $callback): ?ProcessorInterface
    {
        if ($callback->get('acs')) {
            return $this->container->get(AcsProcessor::class);
        }

        return null;
    }
}
