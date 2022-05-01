<?php

namespace App\Stub\Service;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Session\State;

/**
 * Replace callback placeholders {{PLACEHOLDER_NAME}} with values from state init request
 */
class OverrideProcessor implements ProcessorInterface
{
    private const SCHEMA = [
        'TERM_URL' => 'acs_return_url.return_url'
    ];

    public function process(ArrayCollection $callback, State $state): void
    {
        $initialRequest = $state->getInitialRequest();

        foreach (self::SCHEMA as $placeholder => $sourcePath) {
            if ($value = $initialRequest->get($sourcePath)) {
                $callback->replace('{{' . $placeholder . '}}', $value);
            }
        }
    }
}
