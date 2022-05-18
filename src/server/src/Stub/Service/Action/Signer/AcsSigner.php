<?php

namespace App\Stub\Service\Action\Signer;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\ActionSignerInterface;

class AcsSigner implements ActionSignerInterface
{
    /**
     * @inheritDoc
     */
    public function buildActionKey(ArrayCollection $data): string
    {
        if ($data->get('acs.md')) {
            return $data->get('acs.md');
        }

        return $data->get('md');
    }
}
