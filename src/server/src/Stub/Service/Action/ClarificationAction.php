<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\Clarification\ParamsParser;
use App\Stub\Service\Action\Clarification\Parser\LegacyParamsParser;
use App\Stub\Service\Action\Clarification\Parser\SchemaParamsParser;
use App\Stub\Service\Action\Clarification\Parser\SentParamsParser;

class ClarificationAction extends AbstractAction
{
    /**
     * @param ArrayCollection|null $data
     * @return string
     * @throws \Exception
     */
    public function getActionKey(?ArrayCollection $data = null): string
    {
        $strategies = $this->getParseParamsStrategies($data);

        foreach ($strategies as $parser) {
            $names = $parser->getNames();

            if (!empty($names)) {
                sort($names);

                $key = md5(implode(',', $names));

                return $key;
            }
        }

        throw new \Exception('Cant parse clarification fields');
    }

    /**
     * @param ArrayCollection|null $data
     * @return ParamsParser[]
     */
    private function getParseParamsStrategies(?ArrayCollection $data = null)
    {
        $strategies = [];

        if (is_null($data)) {
            $clarificationFields = $this->callback->get('clarification_fields');

            if (is_array($clarificationFields)) {
                $strategies[] = new SchemaParamsParser($clarificationFields);
                $strategies[] = new LegacyParamsParser($clarificationFields);
            }
        } else {
            $clarificationFields = $data->get('additional_data');

            if (is_array($clarificationFields)) {
                $strategies[] = new SentParamsParser($clarificationFields);
            }
        }

        return $strategies;
    }
}
