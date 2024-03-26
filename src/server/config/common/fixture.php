<?php

declare(strict_types=1);

use App\Service\DataLoader;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Injector\Injector;

return [
    DataLoader::class => function (Aliases $aliases, Injector $injector) {
        return $injector->make(DataLoader::class, [
            'routeDefinitions' => require $aliases->get('@fixture/routes.php'),
            'resourceDefinitions' => require $aliases->get('@fixture/resources.php'),
        ]);
    }
];
