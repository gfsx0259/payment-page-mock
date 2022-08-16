<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Repository\ResourceRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Table\Index;

#[Entity(repository: ResourceRepository::class)]
#[Index(columns: ['alias'], unique: true)]
#[Index(columns: ['path'], unique: true)]
class Resource
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'string')]
    private string $path;

    #[Column(type: 'string')]
    private string $alias;

    #[Column(type: 'string')]
    private string $description;

    #[Column(type: 'string')]
    private string $content_type;

    #[Column(type: 'text')]
    private string $content;

    public function __construct(
        string $path,
        string $alias,
        string $description,
        string $content_type,
        string $content
    ) {
        $this->path = $path;
        $this->alias = $alias;
        $this->description = $description;
        $this->content_type = $content_type;
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
