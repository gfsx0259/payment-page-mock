<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Repository\RequestRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior;

#[Entity(repository: RequestRepository::class)]
#[Behavior\CreatedAt(
    field: 'created_at'
)]
class Request
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'string')]
    private string $request_id;

    #[Column(type: 'string', default: 'processing')]
    private string $status;

    public function __construct(string $request_id)
    {
        $this->request_id = $request_id;
    }

    public function getRequestId(): string
    {
        return $this->request_id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
