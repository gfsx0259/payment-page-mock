<?php

declare(strict_types=1);

/** @var array $params */

use App\Stub\Service\Action\Processor\AcsProcessor;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    AcsProcessor::class => static fn (UrlGeneratorInterface $urlGenerator) => new AcsProcessor(
        $urlGenerator,
        $params['host'],
    ),
];
