<?php

declare(strict_types=1);

namespace App\Stub;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

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
}
