<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Yiisoft\DataResponse\DataResponse;
use Yiisoft\DataResponse\DataResponseFormatterInterface;
use Yiisoft\DataResponse\ResponseContentTrait;

/**
 * JsonDataResponseFormatter formats the response data as JSON.
 */
final class JavascriptDataResponseFormatter implements DataResponseFormatterInterface
{
    use ResponseContentTrait;

    /**
     * @var string The Content-Type header for the response.
     */
    private string $contentType = 'application/javascript';

    /**
     * @var string The encoding for the Content-Type header.
     */
    private string $encoding = 'UTF-8';

    /**
     * @inheritDoc
     */
    public function format(DataResponse $dataResponse): ResponseInterface
    {
        /** @psalm-suppress MixedArgument */
        return $this->addToResponse($dataResponse->getResponse(), $dataResponse->getData() ?? null);
    }
}
