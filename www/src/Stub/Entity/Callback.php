<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Collection\CallbackCollection;
use App\Stub\Repository\CallbackRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(repository: CallbackRepository::class)]
class Callback
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'integer')]
    private int $stub_id;

    #[Column(type: 'json')]
    private string $body;

    /**
     * @param int $stubId
     * @param string $body
     */
    public function __construct(int $stubId, string $body)
    {
        $this->stub_id = $stubId;
        $this->body = $body;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBody(): CallbackCollection
    {
        return new CallbackCollection(json_decode($this->body, true));
    }

    /**
     * @param CallbackCollection $body
     */
    public function setBody(CallbackCollection $body): void
    {
        $this->body = json_encode($body);
    }
}
