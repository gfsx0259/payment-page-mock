<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Repository\ResourceRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(repository: ResourceRepository::class)]
class Resource
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'string')]
    private string $slug;

    #[Column(type: 'string')]
    private string $content_type;

    #[Column(type: 'text')]
    private string $content;

    /**
     * @param string $slug
     * @param string $contentType
     * @param string $content
     */
    public function __construct(string $slug, string $contentType, string $content)
    {
        $this->slug = $slug;
        $this->content_type = $contentType;
        $this->content = $content;
    }

    public function getContentType(): string
    {
        return $this->content_type;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
