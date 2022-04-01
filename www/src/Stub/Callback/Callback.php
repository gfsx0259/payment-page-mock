<?php

declare(strict_types=1);

namespace App\Stub\Callback;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use stdClass;

#[Entity(repository: CallbackRepository::class)]
class Callback
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'integer')]
    private int $stub_id;

    #[Column(type: 'json')]
    private string $body;

    public function getId(): int
    {
        return $this->id;
    }

    public function getBody(): stdClass
    {
        return json_decode($this->body);
    }

    /**
     * @param stdClass $body
     */
    public function setBody(stdClass $body): void
    {
        $this->body = json_encode($body);
    }
}
