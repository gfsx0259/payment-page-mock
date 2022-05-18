<?php

declare(strict_types=1);

/** @var array $params */

use App\Stub\Service\OverrideProcessor;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    OverrideProcessor::class => static fn (UrlGeneratorInterface $urlGenerator) => new OverrideProcessor(
        $urlGenerator,
        $params['host'],
    ),
];
