<?php

declare(strict_types=1);

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\ActionException;
use App\Stub\Service\UrlHelper;
use App\Stub\Session\State;

abstract class RedirectAction extends AbstractAction
{
    private UrlHelper $urlHelper;

    public function __construct(
        ArrayCollection $callback,
        State $state,
        UrlHelper $urlHelper
    ) {
        $this->urlHelper = $urlHelper;

        parent::__construct(
            $callback,
            $state
        );
    }

    abstract protected function getRedirectUrl(): string;

    abstract protected function getIdentityKeyName(): string;

    public function getActionKey(?ArrayCollection $completeRequest = null): string
    {
        $identityKeyName = $this->getIdentityKeyName();

        if ($completeRequest === null) {
            $actionKey = $this->urlHelper->getArgumentValue($this->getRedirectUrl(), $identityKeyName);

            if ($actionKey) {
                return $actionKey;
            }

            // redirect action without identity key will never be completed
            return md5('Endless action' . rand(0, 1000));
        }

        if ($completeRequest->get($identityKeyName)) {
            return $completeRequest->get($identityKeyName);
        }

        throw new ActionException("Can not parse $identityKeyName field");
    }
}
