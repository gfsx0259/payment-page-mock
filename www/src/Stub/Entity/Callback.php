<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use stdClass;

#[Entity]
class Callback
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'integer')]
    private int $stub_id;

    #[Column(type: 'json')]
    private string $body;

    public function getBody(): stdClass
    {
        return json_decode($this->body);
    }
}
