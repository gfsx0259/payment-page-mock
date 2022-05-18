<?php

namespace App\Stub\Service;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Session\State;
use Yiisoft\Router\UrlGeneratorInterface;

/**
 * Replace callback placeholders {{PLACEHOLDER_NAME}} with values from state init request
 */
class OverrideProcessor implements ProcessorInterface
{
    private const SCHEMA = [
        'TERM_URL' => 'acs_return_url.return_url',
        'REQUEST_ID' => 'request_id',
        'ACS_URL' => 'acs_url',
    ];

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private string $host,
    ) {}

    public function process(ArrayCollection $callback, State $state): void
    {
        $source = $state->getInitialRequest();

        $source->set('request_id', $state->getRequestId());
        $source->set('acs_url', $this->generateAcsUrl());

        foreach (self::SCHEMA as $placeholder => $sourcePath) {
            if ($value = $source->get($sourcePath)) {
                $callback->replace('{{' . $placeholder . '}}', $value);
            }
        }
    }

    private function generateAcsUrl(): string
    {
        return $this->host . $this->urlGenerator->generate('actions/renderAcs');
    }
}
