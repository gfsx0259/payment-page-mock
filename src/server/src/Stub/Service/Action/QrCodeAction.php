<?php

declare(strict_types=1);

namespace App\Stub\Service\Action;

class QrCodeAction extends RedirectAction
{
    public const DISPLAY_DATA_TYPE = 'qr_data';

    protected function getRedirectUrl(): string
    {
        return $this->callback->get('display_data.0.data');
    }

    protected function getIdentityKeyName(): string
    {
        return 'uniqueKey';
    }
}
