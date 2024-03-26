<?php

declare(strict_types=1);

namespace App\Command\Fixture\Dto;

class ScenarioDto
{
    /**
     * @param string $title
     * @param bool $isDefault
     * @param string $telegramAlias
     * @param string[] $callbacks
     *  @param string $description
     */
    public function __construct(
        public string $title,
        public bool $isDefault = false,
        public string $telegramAlias = '@username',
        public array $callbacks = [],
        public string $description = '...',
    )
    {
    }
}
