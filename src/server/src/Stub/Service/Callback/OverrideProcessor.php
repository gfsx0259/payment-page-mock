<?php

namespace App\Stub\Service\Callback;

use App\Service\QrGenerator;
use App\Stub\Collection\ArrayCollection;
use App\Stub\Entity\Resource;
use App\Stub\Repository\ResourceRepository;
use App\Stub\Session\State;
use App\Stub\Session\StateManager;
use Exception;
use HttpSoft\Message\Uri;
use Psr\Log\LoggerInterface;
use Safe\Exceptions\JsonException;
use Safe\Exceptions\StringsException;
use Yiisoft\Router\UrlGeneratorInterface;

use function Safe\json_encode;
use function Safe\sprintf;

/**
 * Replace callback placeholders {{PLACEHOLDER_NAME}} with values from state init request
 */
class OverrideProcessor implements ProcessorInterface
{
    private const SCHEMA = [
        'TERM_URL' => 'acs_return_url.return_url',
        'REQUEST_ID' => 'request_id',
        'PAYMENT_ID' => 'general.payment_id',
        'ACS_URL' => 'acs_url',
        'ACS_IFRAME_URL' => 'acs_iframe_url',
        'ACS_REDIRECT_URL' => 'acs_redirect_url',
        'APS_URL' => 'aps_url',
        'APS_APP_URL' => 'aps_app_url',
        'APS_WIDGET_URL' => 'additional_data.aps_widget_url',
        'QR_ACCEPT_LINK' => 'qr_accept_link',
        'QR_ACCEPT_IMAGE' => 'qr_accept_image',
    ];

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private ResourceRepository $resourceRepository,
        private StateManager $stateManager,
        private QrGenerator $qrGenerator,
        private LoggerInterface $logger,
        private string $host,
        private string $hostApp,
    ) {}

    public function process(ArrayCollection $callback, State $state): ArrayCollection
    {
        $source = $state->getInitialRequest();

        $source->set('request_id', $state->getRequestId());
        $source->set('acs_url', $this->generateAcsUrl());
        $source->set('acs_iframe_url', $this->generateAcsIframeUrl($state));
        $source->set('acs_redirect_url', $this->generateAcsRedirectUrl($state));
        $source->set('aps_url', $this->generateApsUrl($state));
        $source->set('aps_app_url', $this->generateApsAppUrl($state));

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

        return $this->applyFilters($callback);
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

    private function generateApsAppUrl(State $state): string
    {
        $appUri = $this->urlGenerator->generateAbsolute(
            'app/complete',
            queryParameters: ['uniqueKey' => $this->stateManager->generateAccessKey($state)],
            scheme: $this->hostApp,
            host: '',
        );

        return $this->hostApp . '://' . $appUri;
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

    private function applyFilters(ArrayCollection $callback): ArrayCollection
    {
        if (!$filters = $callback->get('@.filters')) {
            return $callback;
        }

        if (!is_array($filters)) {
            return $callback;
        }

        foreach ($filters as $filter) {
            try {
                $this->applyFilter($callback, $filter['action'], $filter['path']);
            } catch (Exception $exception) {
                $this->logger->warning(
                    sprintf('Can not apply action %s: %s ', $filter['action'], $exception->getMessage())
                );
            }
        }

        return $callback;
    }

    /**
     * @throws JsonException
     * @throws StringsException
     */
    private function applyFilter(ArrayCollection $callback, string $action, string $path): void
    {
        $value = $callback->get($path);

        switch ($action) {
            case 'base64':
                $callback->set($path, is_array($value) ? base64_encode(json_encode($value)) : base64_encode($value));
                break;
            default:
                $this->logger->info(sprintf('Action %s not found', $action));
        }
    }
}
