<?php

namespace App\Stub\Service\Action\Processor;

use App\Stub\Service\Action\ActionAbstractProcessor;
use App\Stub\Service\Action\ActionSignerInterface;
use App\Stub\Service\Action\Signer\Clarification\ClarificationSigner;
use Psr\Container\ContainerInterface;

class ClarificationProcessor extends ActionAbstractProcessor
{
    public function __construct(
        private ContainerInterface $container,
    ) {}

    public function getActionSigner(): ActionSignerInterface
    {
        return $this->container->get(ClarificationSigner::class);
    }
}
