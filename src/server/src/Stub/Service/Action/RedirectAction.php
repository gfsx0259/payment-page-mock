<?php

declare(strict_types=1);

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\ActionException;
use App\Service\RouteMatcher;
use App\Stub\Session\State;

/**
 * This action completes only after client get visited the url @link RedirectAction::getRedirectUrl()
 */
abstract class RedirectAction extends AbstractAction
{
    private RouteMatcher $routeMatcher;

    public function __construct(
        ArrayCollection $callback,
        State $state,
        RouteMatcher $routeMatcher
    ) {
        $this->routeMatcher = $routeMatcher;

        parent::__construct(
            $callback,
            $state
        );
    }

    /**
     * Gets url which must be visited by client
     *
     * @return string - this url must match a route from `routes.php`
     */
    abstract protected function getRedirectUrl(): string;

    /**
     * @inheritDoc
     */
    public function getActionKey(?ArrayCollection $completeRequest = null): string
    {
        $identityKeyName = $this->getIdentityKeyName();

        if ($completeRequest === null) {
            $redirectUrl = $this->getRedirectUrl();
            $actionKey = $this->routeMatcher->parseArgument($redirectUrl, $identityKeyName);

            if ($actionKey) {
                return $actionKey;
            }

            throw new ActionException("Can not find `$identityKeyName` in `$redirectUrl`");
        }

        if ($completeRequest->get($identityKeyName)) {
            return $completeRequest->get($identityKeyName);
        }

        throw new ActionException("Can not parse $identityKeyName field");
    }

    /**
     * Gets argument name from route that matches to url returned from @link RedirectAction::getRedirectUrl()
     *
     * @return string - by value of the key you must be able to get state
     */
    protected function getIdentityKeyName(): string
    {
        return 'uniqueKey';
    }
}
