<?php

namespace App\Stub\Service;

use App\Stub\Collection\CallbackCollection;
use App\Stub\Session\State;

class OverrideProcessor implements ProcessorInterface
{
    private const SCHEMA = [
        'acs.term_url' => 'acs_return_url.return_url'
    ];

    public function process(CallbackCollection $callback, State $state): void
    {
        $initialRequest = $state->getInitialRequest();

        foreach (self::SCHEMA as $targetPath => $sourcePath) {
            if ($value = $initialRequest->get($sourcePath)) {
                if ($callback->get($targetPath)) {
                    $callback->set($targetPath, $value);
                }
            }
        }
    }
}
