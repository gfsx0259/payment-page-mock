<?php

declare(strict_types=1);

namespace App\Stub\Collection;

use Yiisoft\Arrays\ArrayAccessTrait;
use Yiisoft\Arrays\ArrayHelper;

class ArrayCollection
{
    use ArrayAccessTrait;

    public function __construct(
        public array $data
    ) {}

    public function get(string $key): mixed
    {
        return ArrayHelper::getValueByPath($this->data, $key);
    }

    public function set(string $key, mixed $value): void
    {
        ArrayHelper::setValueByPath($this->data, $key, $value);
    }

    public function remove($key): void
    {
        ArrayHelper::removeByPath($this->data, $key);
    }

    public function replace(string $needle, string $value): static
    {
        return (new ReplaceIterator())->replace($this, $needle, $value);
    }
}
