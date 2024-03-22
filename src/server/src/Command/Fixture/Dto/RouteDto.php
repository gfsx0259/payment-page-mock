<?php

declare(strict_types=1);

namespace App\Command\Fixture\Dto;

class RouteDto
{
    /**
     * @param string $route
     * @param string $description
     * @param string $logo
     * @param int $type
     * @param ScenarioDto[] $scenarios
     */
    public function __construct(
        public string $route,
        public string $description,
        public string $logo,
        public int $type,
        public array $scenarios = [],
    )
    {
    }
}
