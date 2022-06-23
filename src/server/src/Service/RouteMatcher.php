<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Http\Message\ServerRequestFactoryInterface;
use Yiisoft\Router\MatchingResult;
use Yiisoft\Router\UrlMatcherInterface;
use Yiisoft\Http\Method;
use Yiisoft\Arrays\ArrayHelper;

class RouteMatcher
{
    public function __construct(
        private UrlMatcherInterface $urlMatcher,
        private ServerRequestFactoryInterface $requestFactory
    ) {}

    /**
     * Parse key from provided url
     *
     * @param string $url
     * @param string $key
     * @return string|null
     */
    public function parseArgument(string $url, string $key): ?string
    {
        $matchingResult = $this->match($url);

        if (!$matchingResult->isSuccess()) {
            return null;
        }

        return ArrayHelper::getValue($matchingResult, $key);
    }

    private function match(string $url): MatchingResult
    {
        return $this->urlMatcher->match(
            $this->requestFactory->createServerRequest(Method::GET, $url)
        );
    }
}
