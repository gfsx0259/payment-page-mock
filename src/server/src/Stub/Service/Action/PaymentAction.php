<?php

declare(strict_types=1);

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\ActionException;
use App\Stub\Session\State;

/**
 * Must be completed by `payment_id`
 */
class PaymentAction extends AbstractAction
{
    private int $cursor;

    public function __construct(ArrayCollection $callback, State $state)
    {
        $this->cursor = $state->getCursor();

        parent::__construct($callback, $state);
    }

    /**
     * @inheritDoc
     */
    public function getActionKey(?ArrayCollection $completeRequest = null): string
    {
        $paymentId = $completeRequest
            ? $completeRequest->get('general.payment_id')
            : $this->state->getInitialRequest()->get('general.payment_id');

        if (!$paymentId) {
            throw new ActionException('Can not get payment_id');
        }

        return md5(static::class . $this->cursor . $paymentId);
    }
}
