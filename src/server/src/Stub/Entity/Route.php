<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Repository\RouteRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Doctrine\Common\Collections\ArrayCollection;

#[Entity(repository: RouteRepository::class)]
class Route
{
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
    public function __construct(string $route, string $title, string $logo, int $type)
    {
        $this->route = $route;
        $this->title = $title;
        $this->logo = $logo;
        $this->type = $type;
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
     * @return ArrayCollection
     */
    public function getStubs(): ArrayCollection
    {
        return $this->stubs;
    }
}
