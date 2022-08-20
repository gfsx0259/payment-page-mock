<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Repository\ResourceRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Table\Index;
use Yiisoft\Arrays\ArrayableInterface;
use Yiisoft\Arrays\ArrayableTrait;

#[Entity(repository: ResourceRepository::class)]
#[Index(columns: ['alias'], unique: true)]
#[Index(columns: ['path'], unique: true)]
class Resource implements ArrayableInterface
{
    use ArrayableTrait;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function getContentType(): string
    {
        return $this->content_type;
    }

    public function setContentType(string $contentType): void
    {
        $this->content_type = $contentType;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getTemplateVariable(): string
    {
        return $this->getAlias() . '_RESOURCE';
    }

    public function toArray(array $fields = [], array $expand = [], bool $recursive = true): array
    {
        return [
            'id' => $this->getId(),
            'content_type' => $this->getContentType(),
            'content' => $this->getContent(),
            'path' => $this->getPath(),
            'alias' => $this->getAlias(),
            'description' => $this->getDescription(),
        ];
    }
}
