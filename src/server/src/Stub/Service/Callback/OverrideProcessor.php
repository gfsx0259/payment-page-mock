<?php

namespace App\Stub\Service\Callback;

use App\Service\QrGenerator;
use App\Stub\Collection\ArrayCollection;
use App\Stub\Entity\Resource;
use App\Stub\Repository\ResourceRepository;
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
        'ACS_IFRAME_URL' => 'acs_iframe_url',
        'ACS_REDIRECT_URL' => 'acs_redirect_url',
        'APS_URL' => 'aps_url',
        'APS_WIDGET_URL' => 'additional_data.aps_widget_url',
        'QR_ACCEPT_LINK' => 'qr_accept_link',
        'QR_ACCEPT_IMAGE' => 'qr_accept_image',
    ];

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private ResourceRepository $resourceRepository,
        private StateManager $stateManager,
        private QrGenerator $qrGenerator,
        private string $host,
    ) {}

    public function process(ArrayCollection $callback, State $state): ArrayCollection
    {
        $source = $state->getInitialRequest();

        $source->set('request_id', $state->getRequestId());
        $source->set('acs_url', $this->generateAcsUrl());
        $source->set('acs_iframe_url', $this->generateAcsIframeUrl($state));
        $source->set('acs_redirect_url', $this->generateAcsRedirectUrl($state));
        $source->set('aps_url', $this->generateApsUrl($state));

        $qrLink = $this->generateQrAcceptUrl($state);

        $source->set('qr_accept_link', $qrLink);
        $source->set('qr_accept_image', $this->qrGenerator->generateDataUri($qrLink));

        $callback->set('@.qr_data', $qrLink);

        foreach (self::SCHEMA as $placeholder => $sourcePath) {
            if ($value = $source->get($sourcePath)) {
                $callback->replace('{{' . $placeholder . '}}', $value);
            }
        }

        /** @var Resource $resource */
        foreach ($this->resourceRepository->findAll() as $resource) {
            $value = $this->generateResourceUrl($resource);

            $callback->replace('{{' . $resource->getTemplateVariable() . '}}', $value);
        }

        return $callback;
    }

    private function generateResourceUrl(Resource $resource): string
    {
        return $this->host . $resource->getPath();
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

    private function generateAcsIframeUrl(State $state): string
    {
        return new Uri($this->host . $this->urlGenerator->generate('actions/renderAcsIframe', [
            'uniqueKey' => $this->stateManager->generateAccessKey($state),
        ]));
    }

    private function generateAcsRedirectUrl(State $state): string
    {
        return new Uri($this->host . $this->urlGenerator->generate('actions/renderAcsRedirect', [
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
