<?php

declare(strict_types=1);

namespace App\Stub\Service;

use Psr\Http\Message\ServerRequestFactoryInterface;
use Yiisoft\Router\UrlMatcherInterface;
use Yiisoft\Http\Method;
use Yiisoft\Arrays\ArrayHelper;

class UrlHelper
{
    public function __construct(
        private UrlMatcherInterface $urlMatcher,
        private ServerRequestFactoryInterface $requestFactory
    ) {
    }

    /**
     * Parse key from provided url
     *
     * @param string $url
     * @param string $key
     * @return string|null
     */
    public function getArgumentValue(string $url, string $key): ?string
    {
        $matchingResult = $this->urlMatcher->match(
            $this->requestFactory->createServerRequest(Method::GET, $url)
        );

        return ArrayHelper::getValue($matchingResult->arguments(), $key);
    }
}
