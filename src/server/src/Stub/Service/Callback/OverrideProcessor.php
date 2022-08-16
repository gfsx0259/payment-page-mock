<?php

namespace App\Stub\Service\Callback;

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
        'APS_URL' => 'aps_url',
        'APS_WIDGET_URL' => 'additional_data.aps_widget_url',
        'QR_ACCEPT_LINK' => 'qr_accept_link',
    ];

    private ?iterable $resources = null;

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private ResourceRepository $resourceRepository,
        private StateManager $stateManager,
        private string $host,
    ) {}

    public function process(ArrayCollection $callback, State $state): ArrayCollection
    {
        $source = $this->getSource($state);

        foreach ($this->getSchema() as $placeholder => $sourcePath) {
            if ($value = $source->get($sourcePath)) {
                $callback->replace('{{' . $placeholder . '}}', $value);
            }
        }

        return $callback;
    }

    private function getSource(State $state): ArrayCollection
    {
        $source = $state->getInitialRequest();
        $resources = $this->getResources();

        $source->set('request_id', $state->getRequestId());
        $source->set('acs_url', $this->generateAcsUrl());
        $source->set('aps_url', $this->generateApsUrl($state));
        $source->set('qr_accept_link', $this->generateQrAcceptUrl($state));

        /** @var $resource Resource */
        foreach ($resources as $resource) {
            $placeholder = $resource->getTemplateVariable();

            $source->set(strtolower($placeholder), $this->generateResourceUrl($resource));
        }

        return $source;
    }

    private function getSchema(): array
    {
        $schema = self::SCHEMA;
        $resources = $this->getResources();

        /** @var $resource Resource */
        foreach ($resources as $resource) {
            $placeholder = $resource->getTemplateVariable();
            $schema[$placeholder] = strtolower($placeholder);
        }

        return $schema;
    }

    private function getResources(): iterable
    {
        if ($this->resources === null) {
            $this->resources = $this->resourceRepository->findAll();
        }

        return $this->resources;
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

    private function generateQrAcceptUrl(State $state): string
    {
        return new Uri($this->host . $this->urlGenerator->generate('actions/renderConfirmationQr', [
            'uniqueKey' => $this->stateManager->generateAccessKey($state),
        ]));
    }
}
