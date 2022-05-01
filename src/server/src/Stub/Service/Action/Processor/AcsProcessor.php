<?php

namespace App\Stub\Service\Action\Processor;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\ProcessorInterface;
use App\Stub\Session\State;
use Yiisoft\Router\UrlGeneratorInterface;

/**
 * Implements redirect logic by processing passed callback:
 * - at begin, set flag indicated that mock is waiting for redirect completion {@see State::registerAction()} and
 * generates ACS URL to complete action
 * - further, checks if flag was changed {@see State::isActionCompleted()}
 *
 * Uses merchant data (acs.md) for action matching.
 */
class AcsProcessor implements ProcessorInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private string $host,
    ) {}

    public function process(ArrayCollection $callback, State $state): void
    {
        $merchantData = $callback->get('acs.md');

        if ($state->isActionCompleted($merchantData)) {
            $state->next();
            return;
        }

        $callback->replace(
            '{{ACS_URL}}',
            $this->generateAcsUrl()
        );

        $state->registerAction($merchantData);
    }

    private function generateAcsUrl(): string
    {
        return $this->host . $this->urlGenerator->generate('actions/renderAcs');
    }
}
