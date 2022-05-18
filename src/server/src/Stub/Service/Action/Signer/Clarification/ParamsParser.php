<?php

namespace App\Stub\Service\Action\Signer\Clarification;

interface ParamsParser
{
    /**
     * Parse clarification fields and get its names in format ['exemple.example.example', 'exemple.example', 'example']
     *
     * @return string[]
     */
    public function getNames(): array;
}
