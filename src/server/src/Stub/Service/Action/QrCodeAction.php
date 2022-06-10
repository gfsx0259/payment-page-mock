<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Session\State;

class QrCodeAction extends AbstractAction
{
    private int $displayDataIndex;

    public const DISPLAY_DATA_TYPE = 'qr_data';

    public function __construct(ArrayCollection $callback, State $state, int $displayDataIndex)
    {
        $this->displayDataIndex = $displayDataIndex;

        parent::__construct($callback, $state);
    }

    /**
     * @inheritDoc
     */
    public function getActionKey(?ArrayCollection $completeRequest = null): string
    {
        if (!is_null($completeRequest)) {
            return $completeRequest->get('data');
        }

        return $this->callback->get("display_data.$this->displayDataIndex.data");
    }
}
