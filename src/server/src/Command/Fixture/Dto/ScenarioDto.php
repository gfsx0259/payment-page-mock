<?php

declare(strict_types=1);

namespace App\Command\Fixture\Dto;

class ScenarioDto
{
    /**
     * @param string $title
     * @param bool $isDefault
     * @param string $description
     * @param string $telegramAlias
     * @param string[] $callbacks
     */
    public function __construct(
        public string $title,
        public bool $isDefault = false,
        public string $description = '...',
        public string $telegramAlias = '@username',
        public array $callbacks = [],
    )
    {
    }
}
