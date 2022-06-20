<?php

declare(strict_types=1);

namespace App\Service\Queue;

/**
 * It converts all public properties to json string during serializing object
 */
abstract class AbstractJob implements JobInterface
{
    public $delay = 0;

    /**
     * @inheritDoc
     */
    public function getDelay(): int
    {
        return $this->delay;
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return json_encode(get_object_vars($this));
    }

    /**
     * @inheritDoc
     */
    public function initFromString(string $data): void
    {
        $dataParsed = json_decode($data, true);

        foreach ($dataParsed as $key => $value) {
            $this->$key = $value;
        }
    }
}
