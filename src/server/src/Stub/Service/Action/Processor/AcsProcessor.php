<?php

namespace App\Stub\Service\Action\Processor;

use App\Stub\Service\Action\ActionAbstractProcessor;
use App\Stub\Service\Action\ActionSignerInterface;
use App\Stub\Service\Action\Signer\AcsSigner;
use App\Stub\Session\State;
use Psr\Container\ContainerInterface;

/**
 * Implements redirect logic by processing passed callback:
 * - at begin, set flag indicated that mock is waiting for redirect completion {@see State::registerAction()} and
 * generates ACS URL to complete action
 * - further, checks if flag was changed {@see State::isActionCompleted()}
 *
 * Uses merchant data (acs.md) for action matching.
 */
class AcsProcessor extends ActionAbstractProcessor
{
    public function __construct(
        private ContainerInterface $container,
    ) {}

    public function getActionSigner(): ActionSignerInterface
    {
        return $this->container->get(AcsSigner::class);
    }
}
