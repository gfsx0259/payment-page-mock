<?php

declare(strict_types=1);

/** @var array $params */

use App\Service\Queue\Broker\RabbitMQBroker;
use App\Service\Queue\BrokerInterface;
use App\Service\Queue\Queue;
use App\Service\Queue\QueueInterface;
use App\Stub\Job\SendCallbackJob;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Injector\Injector;
use Bunny\Client;

return [
    BrokerInterface::class => function () {
        $client = new Client([
            'host' => ArrayHelper::getValue($_ENV, 'RABBITMQ_HOST'),
            'user' => ArrayHelper::getValue($_ENV, 'RABBITMQ_DEFAULT_USER'),
            'password' => ArrayHelper::getValue($_ENV, 'RABBITMQ_DEFAULT_PASS'),
        ]);

        return new RabbitMQBroker($client);
    },
    QueueInterface::class => function (Injector $injector) {
        $mapping = [
            ['queue_name' => ArrayHelper::getValue($_ENV, 'API_CALLBACKS_QUEUE_NAME'), 'jobs' => [SendCallbackJob::class]],
        ];

        return $injector->make(Queue::class, ['mapping' => $mapping]);
    },
];
