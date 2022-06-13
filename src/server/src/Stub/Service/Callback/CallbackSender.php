<?php

namespace App\Stub\Service\Callback;

use App\Stub\Collection\ArrayCollection;
use GuzzleHttp\ClientInterface;
use itechpsp\SignatureHandler;
use Psr\Log\LoggerInterface;
use Throwable;

class CallbackSender
{
    private const SIGNATURE_PATH = 'general.signature';

    public function __construct(
        private ClientInterface $httpClient,
        private LoggerInterface $logger,
        private string $secret,
    ) {}

    public function send(ArrayCollection $callbackCollection): void
    {
        $callbackCollection->remove(self::SIGNATURE_PATH);

        $callbackCollection->set(
            self::SIGNATURE_PATH,
            (new SignatureHandler($this->secret))->sign($callbackCollection->data)
        );

        try {
            $this->httpClient->post('callbacks', [
                'json' => $callbackCollection->data,
            ]);
            $this->logger->info('Send callback successfully');
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
