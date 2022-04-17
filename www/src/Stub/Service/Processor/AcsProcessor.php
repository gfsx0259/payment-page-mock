<?php

namespace App\Stub\Service\Processor;

use App\Stub\Collection\CallbackCollection;
use App\Stub\Service\ProcessorInterface;
use App\Stub\Session\State;
use Yiisoft\Router\UrlGeneratorInterface;

class AcsProcessor implements ProcessorInterface
{
    private UrlGeneratorInterface $urlGenerator;
    private string $host;

    public function __construct(UrlGeneratorInterface $urlGenerator, $host)
    {
        $this->urlGenerator = $urlGenerator;
        $this->host = $host;
    }

    public function process(CallbackCollection $callback, State $state): void
    {
        if ($state->isActionCompleted($callback->get('acs.md'))) {
            $state->increaseCount();
            return;
        }

        if ($callback->get('acs.acs_url') === '{{ACS_URL}}') {
            $callback->set('acs.acs_url', $this->generateAcsUrl());
            $state->registerAction($callback->get('acs.md'));
        }
    }

    private function generateAcsUrl(): string
    {
        return $this->host . $this->urlGenerator->generate('actions/renderAcs');
    }
}
