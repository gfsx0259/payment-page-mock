<?php

declare(strict_types=1);

namespace App\Stub\Service\Action;

/**
 * Step of a payment with showing QR code can be passed only by completing this action
 */
class QrCodeAction extends RedirectAction
{
    public const DISPLAY_DATA_TYPE_RAW = 'qr_data';

    /**
     * @inheritDoc
     */
    protected function getRedirectUrl(): string
    {
        return $this->callback->get('display_data.0.data');
    }
}
