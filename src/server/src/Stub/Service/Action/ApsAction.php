<?php

namespace App\Stub\Service\Action;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\ActionException;
use App\Stub\Session\State;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Http\Method;
use Yiisoft\Router\UrlMatcherInterface;

/**
 * Uses unique key from Payment System url for action matching.
 */
class ApsAction extends AbstractAction
{
    private UrlMatcherInterface $urlMatcher;
    private ServerRequestFactoryInterface $requestFactory;

    public function __construct(
        ArrayCollection $callback,
        State $state,
        UrlMatcherInterface $urlMatcher,
        ServerRequestFactoryInterface $requestFactory
    ) {
        $this->urlMatcher = $urlMatcher;
        $this->requestFactory = $requestFactory;

        parent::__construct(
            $callback,
            $state
        );
    }

    public function getActionKey(?ArrayCollection $completeRequest = null): string
    {
        if ($completeRequest === null) {
            return $this->parseUniqueKey($this->callback->get('return_url.url'));
        }

        if ($completeRequest->get('uniqueKey')) {
            return $completeRequest->get('uniqueKey');
        }

        throw new ActionException('Can not parse uniqueKey field');
    }

    /**
     * Parse unique key from provided aps url
     *
     * @param string $apsUri
     * @return string
     */
    private function parseUniqueKey(string $apsUri): string
    {
        $matchingResult = $this->urlMatcher->match(
            $this->requestFactory->createServerRequest(Method::GET, $apsUri)
        );

        return ArrayHelper::getValue($matchingResult->arguments(), 'uniqueKey');
    }
}
