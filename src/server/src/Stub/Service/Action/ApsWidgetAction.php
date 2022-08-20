<?php

declare(strict_types=1);

namespace App\Stub\Service\Action;

/**
 * Uses unique key from Payment System url for action matching.
 */
class ApsWidgetAction extends RedirectAction
{
    /**
     * @inheritDoc
     */
    protected function getRedirectUrl(): string
    {
        return $this->callback->get('return_url.body.callback_url');
    }
}
