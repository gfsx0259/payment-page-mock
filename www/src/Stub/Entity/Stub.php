<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\StubRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Doctrine\Common\Collections\ArrayCollection;

#[Entity(repository: StubRepository::class)]
class Stub
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'string(128)')]
    private string $route;

    #[Column(type: 'string(191)')]
    private string $title = '';

    #[HasMany(Callback::class)]
    private ArrayCollection $callbacks;

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
     * @return ArrayCollection
     */
    public function getCallbacks(): ArrayCollection
    {
        return $this->callbacks;
    }
}
