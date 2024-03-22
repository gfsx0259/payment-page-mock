<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Repository\RouteRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Doctrine\Common\Collections\ArrayCollection;
use Yiisoft\Arrays\ArrayableInterface;
use Yiisoft\Arrays\ArrayableTrait;

#[Entity(repository: RouteRepository::class)]
class Route implements ArrayableInterface
{
    use ArrayableTrait;

    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'string(128)')]
    private string $route;

    #[Column(type: 'string(191)')]
    private string $title = '';

    #[Column(type: 'string(191)')]
    private string $logo = '';

    #[Column(type: 'integer')]
    private int $type;

    #[HasMany(Stub::class)]
    private ArrayCollection $stubs;

    /**
     * @param string $route
     * @param string $title
     * @param string $logo
     * @param int $type
     */
    public function __construct(string $route = '', string $title = '', string $logo = '', int $type = 0)
    {
        $this->route = $route;
        $this->title = $title;
        $this->logo = $logo;
        $this->type = $type;
        $this->stubs = new ArrayCollection();
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
    public function getRoute(): string
    {
        return $this->route;
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
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $logo
     */
    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection
     */
    public function getStubs(): ArrayCollection
    {
        return $this->stubs;
    }

    public function addStubs(Stub $stub): void
    {
        $this->stubs->add($stub);
    }

    public function toArray(array $fields = [], array $expand = [], bool $recursive = true): array
    {
        return [
            'id' => $this->id,
            'path' => $this->route,
            'description' => $this->title,
            'type' => $this->type,
            'logo' => $this->logo,
        ];
    }
}
