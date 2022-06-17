<?php

declare(strict_types=1);

/** @var array $params */

use App\Command\Queue\ListenAllCommand;

return [
    ListenAllCommand::class => new ListenAllCommand($params['app/queue']),
];
