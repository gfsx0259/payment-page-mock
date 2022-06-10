<?php

declare(strict_types=1);

/** @var array $params */

use App\Stub\Service\CallbackSender;
use App\Stub\Service\OverrideProcessor;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    OverrideProcessor::class => static fn (UrlGeneratorInterface $urlGenerator) => new OverrideProcessor(
        $urlGenerator,
        $params['host'],
    ),
    CallbackSender::class => function(LoggerInterface $logger) {
        $client = new Client([
            'base_uri' => 'http://pp.terminal.test',
            'headers' => ['Content-Type' => 'application/json'],
        ]);
        return new CallbackSender(
            $client,
            $logger,
            $_ENV['INTERNAL_SECRET']
        );
    }
];
