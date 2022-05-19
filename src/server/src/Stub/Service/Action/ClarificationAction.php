<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\Clarification\ParamsParser;
use App\Stub\Service\Action\Clarification\Parser\LegacyParamsParser;
use App\Stub\Service\Action\Clarification\Parser\SchemaParamsParser;
use App\Stub\Service\Action\Clarification\Parser\SentParamsParser;
use App\Stub\Service\ActionException;

class ClarificationAction extends AbstractAction
{
    public function getActionKey(?ArrayCollection $completeRequest = null): string
    {
        $strategies = $this->getParseParamsStrategies($completeRequest);

        foreach ($strategies as $parser) {
            $names = $parser->getNames();

            if (!empty($names)) {
                sort($names);

                return md5(implode(',', $names));
            }
        }

        throw new ActionException('Can not parse clarification fields');
    }

    /**
     * @param ArrayCollection|null $completeRequest
     * @return ParamsParser[]
     */
    private function getParseParamsStrategies(?ArrayCollection $completeRequest = null): array
    {
        $strategies = [];

        if (is_null($completeRequest)) {
            $clarificationFields = $this->callback->get('clarification_fields');

            if (is_array($clarificationFields)) {
                $strategies[] = new SchemaParamsParser($clarificationFields);
                $strategies[] = new LegacyParamsParser($clarificationFields);
            }
        } else {
            $clarificationFields = $completeRequest->get('additional_data');

            if (is_array($clarificationFields)) {
                $strategies[] = new SentParamsParser($clarificationFields);
            }
        }

        return $strategies;
    }
}
