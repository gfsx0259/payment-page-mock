<?php

declare(strict_types=1);

namespace App\Provider;

use Psr\SimpleCache\CacheInterface;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Cache\Cache;
use Yiisoft\Cache\CacheInterface as YiiCacheInterface;
use Yiisoft\Cache\Memcached\Memcached;

return [
    CacheInterface::class => new Memcached('', [
        [
            'host' => ArrayHelper::getValue($_ENV, 'DUMMY_MEMCACHED_HOST'),
            'port' => ArrayHelper::getValue($_ENV, 'DUMMY_MEMCACHED_PORT'),
        ],
    ]),
    YiiCacheInterface::class => Cache::class,
];
