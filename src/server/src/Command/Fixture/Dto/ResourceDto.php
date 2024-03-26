<?php

declare(strict_types=1);

namespace App\Command\Fixture\Dto;

class ResourceDto
{
    /**
     * @param string $path
     * @param string $alias
     * @param string $contentPath
     * @param string $contentType
     * @param string $description
     */
    public function __construct(
        public string $path,
        public string $alias,
        public string $contentPath,
        public string $contentType = 'application/json',
        public string $description = '...'
    )
    {
    }
}
