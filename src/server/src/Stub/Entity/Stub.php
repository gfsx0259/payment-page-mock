<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Cycle\JsonTypecast;
use App\Stub\Repository\StubRepository;
use App\Stub\Service\Specification\SpecificationEntityInterface;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\ORM\Parser\Typecast;
use Doctrine\Common\Collections\ArrayCollection;
use Yiisoft\Arrays\ArrayableInterface;
use Yiisoft\Arrays\ArrayableTrait;

#[Entity(
    repository: StubRepository::class,
    typecast: [
        Typecast::class,
        JsonTypecast::class,
    ]
)]
class Stub implements ArrayableInterface, SpecificationEntityInterface
{
    use ArrayableTrait;

    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'integer')]
    private ?int $route_id;

    #[Column(type: 'string(191)')]
    private string $title;

    #[Column(type: 'text')]
    private string $description;

    #[Column(type: 'string(191)')]
    private string $creator_telegram_alias;

    #[Column(type: 'boolean', default: false)]
    private bool $default = false;

    #[Column(type: 'json', typecast: 'json')]
    private array $conditions;

    #[HasMany(Callback::class, orderBy: ['order' => 'asc'])]
    private ArrayCollection $callbacks;

    public function __construct(
        string $title,
        string $description,
        string $telegramAlias,
        array $conditions = [],
        ?int $routeId = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->creator_telegram_alias = $telegramAlias;
        $this->route_id = $routeId;
        $this->conditions = $conditions;
        $this->callbacks = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatorTelegramAlias(): string
    {
        return $this->creator_telegram_alias;
    }

    public function setCreatorTelegramAlias(string $alias): self
    {
        $this->creator_telegram_alias = $alias;
        return $this;
    }

    public function getCallbacks(): ArrayCollection
    {
        return $this->callbacks;
    }

    public function addCallback(Callback $callback): self
    {
        $this->callbacks->add($callback);
        return $this;
    }

    public function getIsDefault(): bool
    {
        return $this->default;
    }

    public function setIsDefault(bool $default): self
    {
        $this->default = $default;
        return $this;
    }

    public function getSpecification(): array
    {
        return $this->conditions ?? [];
    }

    public function setSpecification(array $specification): self
    {
        $this->conditions = $specification;
        return $this;
    }

    public function toArray(array $fields = [], array $expand = [], bool $recursive = true): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'creator_telegram_alias' => $this->getCreatorTelegramAlias(),
            'default' => $this->getIsDefault(),
            'callbacks' => $this->getCallbacks()->map(fn (Callback $callback) => $callback->toArray()),
            'conditions' => $this->getSpecification(),
        ];
    }
}
