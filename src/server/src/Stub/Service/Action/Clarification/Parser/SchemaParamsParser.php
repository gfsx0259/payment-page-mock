<?php

namespace App\Stub\Service\Action\Clarification\Parser;

use App\Stub\Service\Action\Clarification\ParamsParser;
use stdClass;
use Yiisoft\Arrays\ArrayHelper;

class SchemaParamsParser implements ParamsParser
{
    private array $names;

    public function __construct(
        private array $rawData
    ) {
    }

    private function parse(): void
    {
        $this->names = [];

        foreach ($this->rawData as $name => $schema) {
            if (!is_array($schema) || ArrayHelper::getValueByPath($schema, 'type') === null) {
                return;
            } else {
                $objSchema = json_decode(json_encode($schema));
                $paths = $this->parseSchema($objSchema);

                foreach ($paths as $path) {
                    $this->names[] = $name . '.' . $path;
                }
            }
        }

        $this->names = array_unique($this->names);
    }

    private function parseSchema(stdClass $schema, string $rootAttribute = '', array &$paramsNames = []): array
    {
        if (property_exists($schema, 'properties')) {
            foreach ($schema->properties as $propertyName => $property) {
                if (substr($propertyName, 0, 1) === '$') {
                    continue;
                }

                $attrDottedName = ($rootAttribute ? $rootAttribute . '.' : null) . $propertyName;

                if (property_exists($property, 'properties')) {
                    // parse schema deeper
                    $this->parseSchema($property, $attrDottedName, $paramsNames);
                } else {
                    // take property to name chain
                    $paramsNames[] = $attrDottedName;
                }
            }
        } else {
            $paramsNames[] = $rootAttribute;
        }

        return array_unique($paramsNames);
    }

    public function getNames(): array
    {
        if (empty($this->names)) {
            $this->parse();
        }

        return $this->names;
    }
}
