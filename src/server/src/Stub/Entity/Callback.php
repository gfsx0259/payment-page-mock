<?php

declare(strict_types=1);

namespace App\Stub\Entity;

use App\Stub\Repository\CallbackRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Yiisoft\Arrays\ArrayableInterface;
use Yiisoft\Arrays\ArrayableTrait;

#[Entity(repository: CallbackRepository::class)]
class Callback implements ArrayableInterface
{
    use ArrayableTrait;

    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'integer')]
    private ?int $stub_id;

    #[Column(type: 'integer')]
    private int $order;

    #[Column(type: 'json')]
    private string $body;

    /**
     * @param string $body
     * @param int $order
     * @param int|null $stubId
     */
    public function __construct(string $body, int $order, ?int $stubId = null)
    {
        $this->body = $body;
        $this->order = $order;
        $this->stub_id = $stubId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBody(): array
    {
        return json_decode($this->body, true);
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = json_encode($body);
    }

    /**
     * @param int $order
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function toArray(array $fields = [], array $expand = [], bool $recursive = true): array
    {
        return [
            'id' => $this->getId(),
            'body' => $this->getBody(),
        ];
    }
}
