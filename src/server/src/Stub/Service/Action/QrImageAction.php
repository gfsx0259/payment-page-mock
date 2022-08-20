<?php

declare(strict_types=1);

namespace App\Stub\Service\Action;

/**
 * Step of a payment with showing QR code can be passed only by completing this action
 */
class QrImageAction extends RedirectAction
{
    /**
     * @inheritDoc
     */
    protected function getRedirectUrl(): string
    {
        return $this->callback->get('@.qr_data');
    }
}
