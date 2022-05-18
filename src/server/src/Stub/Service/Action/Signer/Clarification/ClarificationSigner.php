<?php

namespace App\Stub\Service\Action\Signer\Clarification;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\ActionSignerInterface;
use App\Stub\Service\Action\Signer\Clarification\Parser\LegacyParamsParser;
use App\Stub\Service\Action\Signer\Clarification\Parser\SchemaParamsParser;
use App\Stub\Service\Action\Signer\Clarification\Parser\SentParamsParser;

class ClarificationSigner implements ActionSignerInterface
{
    /**
     * @inheritDoc
     */
    public function buildActionKey(ArrayCollection $data): string
    {
        /** @var ParamsParser[] $strategies */
        $strategies = [];

        if (is_array($data->get('additional_data'))) {
            $strategies[] = new SentParamsParser($data->get('additional_data'));
        } elseif (is_array($data->get('clarification_fields'))) {
            $strategies[] = new SchemaParamsParser($data->get('clarification_fields'));
            $strategies[] = new LegacyParamsParser($data->get('clarification_fields'));
        }

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
}
