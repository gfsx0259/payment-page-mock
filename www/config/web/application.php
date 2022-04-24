<?php

declare(strict_types=1);

use App\Handler\NotFoundHandler;
use App\Middleware\LocaleMiddleware;
use Neomerx\Cors\Contracts\Constants\CorsResponseHeaders;
use Tuupola\Middleware\CorsMiddleware;
use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Definitions\Reference;
use Yiisoft\Injector\Injector;
use Yiisoft\Middleware\Dispatcher\MiddlewareDispatcher;

/** @var array $params */

return [
    Yiisoft\Yii\Http\Application::class => [
        '__construct()' => [
            'dispatcher' => DynamicReference::to(static function (Injector $injector) use ($params) {
                return ($injector->make(MiddlewareDispatcher::class))
                    ->withMiddlewares($params['middlewares']);
            }),
            'fallbackHandler' => Reference::to(NotFoundHandler::class),
        ],
    ],
    LocaleMiddleware::class => [
        '__construct()' => [
            'locales' => $params['locales'],
        ],
    ],
    CorsMiddleware::class => [
        '__construct()' => [
            'options' => [
                'headers.allow' => [
                    CorsResponseHeaders::ALLOW_ORIGIN => '*',
                    CorsResponseHeaders::ALLOW_HEADERS => 'Content-Type',
                ],
            ],
        ],
    ],
];
