<?php

declare(strict_types=1);

namespace App\Service\Queue;

abstract class AbstractJob implements JobInterface
{
    public $delay = 0;

    public function serialize(): string
    {
        return json_encode(get_object_vars($this));
    }

    public function getDelay(): int
    {
        return $this->delay;
    }

    public function initFromString(string $data): void
    {
        $dataParsed = json_decode($data, true);

        foreach ($dataParsed as $key => $value) {
            $this->$key = $value;
        }
    }
}
