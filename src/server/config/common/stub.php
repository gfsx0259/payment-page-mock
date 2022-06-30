<?php

declare(strict_types=1);

/** @var array $params */

use App\Stub\Service\Callback\CallbackSender;
use App\Stub\Service\Callback\OverrideProcessor;
use App\Stub\Session\StateManager;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    OverrideProcessor::class => static fn (
        UrlGeneratorInterface $urlGenerator,
        StateManager $stateManager
    ) => new OverrideProcessor(
        $urlGenerator,
        $stateManager,
        $params['host'],
    ),
    CallbackSender::class => function (LoggerInterface $logger) {
        $url = ArrayHelper::getValue($_ENV, 'CALLBACK_URL');
        $secret = ArrayHelper::getValue($_ENV, 'CALLBACK_SECRET');

        if (!($url && $secret)) {
            throw new Exception('Can not initialize callback sender');
        }

        $client = new Client([
            'base_uri' => $url . '/',
        ]);
        return new CallbackSender(
            $client,
            $logger,
            $secret
        );
    },
];
