<?php

declare(strict_types=1);

/** @var array $params */

use App\Service\Queue\Queue;
use App\Service\Queue\QueueInterface;
use App\Stub\Job\SendCallbackJob;
use Cycle\ORM\ORMInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Injector\Injector;
use Bunny\Client;

return [
    QueueInterface::class => function (Injector $injector, LoggerInterface $logger, ORMInterface $orm) {
        $client = new Client([
            'host' => ArrayHelper::getValue($_ENV, 'RABBITMQ_HOST'),
            'user' => ArrayHelper::getValue($_ENV, 'RABBITMQ_DEFAULT_USER'),
            'password' => ArrayHelper::getValue($_ENV, 'RABBITMQ_DEFAULT_PASS'),
        ]);

        $config = [
            ['name' => ArrayHelper::getValue($_ENV, 'CALLBACKS_QUEUE_NAME'), 'jobs' => [SendCallbackJob::class]],
        ];

        return new Queue(
            $client,
            $injector,
            $logger,
            $orm,
            $config
        );
    },
];
