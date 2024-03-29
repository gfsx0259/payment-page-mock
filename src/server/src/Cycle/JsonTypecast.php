<?php

namespace App\Cycle;

use Cycle\ORM\Parser\CastableInterface;
use Cycle\ORM\Parser\UncastableInterface;

final class JsonTypecast implements CastableInterface, UncastableInterface
{
    private array $rules = [];

    public function setRules(array $rules): array
    {
        foreach ($rules as $key => $rule) {
            if ($rule === 'json') {
                unset($rules[$key]);
                $this->rules[$key] = $rule;
            }
        }

        return $rules;
    }

    public function cast(array $data): array
    {
        foreach ($this->rules as $column => $rule) {
            if (!isset($data[$column])) {
                continue;
            }

            $data[$column] = json_decode($data[$column], true) ?? [];
        }

        return $data;
    }

    public function uncast(array $data): array
    {
        foreach ($this->rules as $column => $rule) {
            if (!isset($data[$column])) {
                continue;
            }

            $data[$column] = json_encode($data[$column]);
        }

        return $data;
    }
}
