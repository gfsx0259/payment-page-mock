<?php

declare(strict_types=1);

/** @var array $params */

use App\Service\Queue\Queue;
use App\Service\Queue\QueueInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Injector\Injector;

return [
    QueueInterface::class => function (Injector $injector, LoggerInterface $logger) use ($params) {
        $credentials = [
            'host' => ArrayHelper::getValue($_ENV, 'RABBITMQ_HOST'),
            'user' => ArrayHelper::getValue($_ENV, 'RABBITMQ_DEFAULT_USER'),
            'password' => ArrayHelper::getValue($_ENV, 'RABBITMQ_DEFAULT_PASS'),
        ];

        return new Queue($injector, $logger, $credentials, $params['app/queue']);
    },
];
