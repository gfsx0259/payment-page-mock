<?php

declare(strict_types=1);

/** @var array $params */

use App\Service\QrGenerator;
use App\Stub\Repository\ResourceRepository;
use App\Stub\Service\Callback\CallbackSender;
use App\Stub\Service\Callback\CallbackSenderInterface;
use App\Stub\Service\Callback\CallbackSenderMock;
use App\Stub\Service\Callback\OverrideProcessor;
use App\Stub\Session\StateManager;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    OverrideProcessor::class => static fn (
        UrlGeneratorInterface $urlGenerator,
        ResourceRepository $resourceRepository,
        StateManager $stateManager,
        QrGenerator $qrGenerator,
        LoggerInterface $logger
    ) => new OverrideProcessor(
        $urlGenerator,
        $resourceRepository,
        $stateManager,
        $qrGenerator,
        $logger,
        $params['host'],
    ),
    CallbackSenderInterface::class => function (LoggerInterface $logger) {
        if (ArrayHelper::getValue($_ENV, 'DUMMY_API_DISABLE_SENDING_CALLBACKS')) {
            return new CallbackSenderMock($logger);
        }

        $secret = ArrayHelper::getValue($_ENV, 'DUMMY_API_CALLBACK_SECRET');

        if (!$secret) {
            throw new Exception('Can not initialize callback sender');
        }

        $client = new Client();

        return new CallbackSender(
            $client,
            $logger,
            $secret
        );
    },
];
