<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;

class AcsAction extends AbstractAction
{
    public function getActionKey(?ArrayCollection $data = null): string
    {
        if (is_null($data)) {
            return $this->callback->get('acs.md');
        } elseif ($data->get('md')) {
            return $data->get('md');
        }

        throw new \Exception('Cant find md field');
    }
}
