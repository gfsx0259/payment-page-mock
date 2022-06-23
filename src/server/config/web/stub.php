<?php

declare(strict_types=1);

/** @var array $params */

use App\Stub\Service\OverrideProcessor;
use App\Stub\Session\StateManager;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    OverrideProcessor::class => static fn (
        UrlGeneratorInterface $urlGenerator,
        StateManager $stateManager
    ) => new OverrideProcessor(
        $urlGenerator,
        $stateManager,
        $params['host']
    ),
];
