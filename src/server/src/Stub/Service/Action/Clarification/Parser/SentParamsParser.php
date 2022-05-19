<?php

namespace App\Stub\Service\Action\Clarification\Parser;

use App\Stub\Service\Action\Clarification\ParamsParser;

class SentParamsParser implements ParamsParser
{
    private array $names;

    public function __construct(
        private array $rawData
    ) {}

    private function parse(?array $source = null, ?string $prefix = null): void
    {
        if (!$source) {
            $source = $this->rawData;
        }

        foreach ($source as $key => $value) {
            if (is_numeric($key)) {
                if ($prefix) {
                    $this->names[] = $prefix;
                }

                break;
            }

            $name = ($prefix ? ($prefix . '.') : '') . $key;

            if (is_array($value)) {
                $this->parse($value, $name);
            } else {
                $this->names[] = $name;
            }
        }
    }

    public function getNames(): array
    {
        if (empty($this->names)) {
            $this->parse();
        }

        return $this->names;
    }
}
