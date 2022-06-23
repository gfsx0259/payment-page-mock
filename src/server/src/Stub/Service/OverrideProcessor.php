<?php

namespace App\Stub\Service;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Session\State;
use App\Stub\Session\StateManager;
use HttpSoft\Message\Uri;
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
        'APS_URL' => 'aps_url',
        'QR_ACCEPT_LINK' => 'qr_accept_link',
    ];

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private StateManager $stateManager,
        private string $host,
    ) {
    }

    public function process(ArrayCollection $callback, State $state): void
    {
        $source = $state->getInitialRequest();

        $source->set('acs_url', $this->generateAcsUrl());
        $source->set('aps_url', $this->generateApsUrl($state));
        $source->set('qr_accept_link', $this->generateQrAcceptUrl($state));

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

    private function generateApsUrl(State $state): string
    {
        return new Uri($this->host . $this->urlGenerator->generate('actions/renderAps', [
            'uniqueKey' => $this->stateManager->generateAccessKey($state),
        ]));
    }

    private function generateQrAcceptUrl(State $state): string
    {
        return new Uri($this->host . $this->urlGenerator->generate('actions/renderConfirmationQr', [
            'uniqueKey' => $this->stateManager->generateAccessKey($state),
        ]));
    }
}
