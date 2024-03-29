<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Repository\StubRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Doctrine\Common\Collections\ArrayCollection;
use Yiisoft\Arrays\ArrayableInterface;
use Yiisoft\Arrays\ArrayableTrait;

#[Entity(repository: StubRepository::class)]
class Stub implements ArrayableInterface
{
    use ArrayableTrait;

    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'integer')]
    private ?int $route_id;

    #[Column(type: 'string(191)')]
    private string $title = '';

    #[Column(type: 'text')]
    private string $description = '';

    #[Column(type: 'string(191)')]
    private string $creator_telegram_alias = '';

    #[Column(type: 'boolean', default: false)]
    private bool $default;

    #[HasMany(Callback::class, orderBy: ['order' => 'asc'])]
    private ArrayCollection $callbacks;

    /**
     * @param string $title
     * @param string $description
     * @param string $telegramAlias
     * @param int|null $routeId
     */
    public function __construct(string $title, string $description, string $telegramAlias, ?int $routeId = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->creator_telegram_alias = $telegramAlias;
        $this->route_id = $routeId;
        $this->callbacks = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCreatorTelegramAlias(): string
    {
        return $this->creator_telegram_alias;
    }

    /**
     * @return ArrayCollection
     */
    public function getCallbacks(): ArrayCollection
    {
        return $this->callbacks;
    }

    public function addCallback(Callback $callback): void
    {
        $this->callbacks->add($callback);
    }

    /**
     * @return bool
     */
    public function getDefault(): bool
    {
        return $this->default;
    }

    /**
     * @param bool $default
     * @return void
     */
    public function setDefault(bool $default): void
    {
        $this->default = $default;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $alias
     * @return void
     */
    public function setCreatorTelegramAlias(string $alias): void
    {
        $this->creator_telegram_alias = $alias;
    }

    public function toArray(array $fields = [], array $expand = [], bool $recursive = true): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'creator_telegram_alias' => $this->getCreatorTelegramAlias(),
            'default' => $this->getDefault(),
            'callbacks' => $this->getCallbacks()->map(fn (Callback $callback) => $callback->toArray()),
        ];
    }
}
