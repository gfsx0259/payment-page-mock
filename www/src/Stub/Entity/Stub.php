<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Repository\StubRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Doctrine\Common\Collections\ArrayCollection;
use JetBrains\PhpStorm\Pure;

#[Entity(repository: StubRepository::class)]
class Stub
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'integer')]
    private int $route_id;

    #[Column(type: 'string(191)')]
    private string $title = '';

    #[Column(type: 'text')]
    private string $description = '';

    #[HasMany(Callback::class)]
    private ArrayCollection $callbacks;

    /**
     * @param int $routeId
     * @param string $title
     * @param string $description
     */
    #[Pure] public function __construct(int $routeId, string $title, string $description)
    {
        $this->route_id = $routeId;
        $this->title = $title;
        $this->description = $description;
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
     * @return ArrayCollection
     */
    public function getCallbacks(): ArrayCollection
    {
        return $this->callbacks;
    }
}
