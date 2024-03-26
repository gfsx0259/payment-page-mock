<?php

declare(strict_types=1);

namespace App\Command\Fixture\Dto;

class RouteDto
{
    /**
     * @param string $route
     * @param string $logo
     * @param int $type
     * @param ScenarioDto[] $scenarios
     * @param string $description
     */
    public function __construct(
        public string $route,
        public string $logo,
        public int $type,
        public array $scenarios = [],
        public string $description = '...',
    )
    {
    }
}
