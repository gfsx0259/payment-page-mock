<?php

declare(strict_types=1);

/** @var array $params */

use App\Command\Queue\ListenAllCommand;
use App\Service\Queue\QueueInterface;

return [
    ListenAllCommand::class => function (QueueInterface $queue) use ($params) {
        return new ListenAllCommand($queue, $params['app/queue']);
    },
];
