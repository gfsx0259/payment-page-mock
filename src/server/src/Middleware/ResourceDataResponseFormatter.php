<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Stub\Entity\Resource;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\DataResponse\DataResponse;
use Yiisoft\DataResponse\DataResponseFormatterInterface;
use Yiisoft\DataResponse\ResponseContentTrait;

final class ResourceDataResponseFormatter implements DataResponseFormatterInterface
{
    use ResponseContentTrait;

    /**
     * @var string The Content-Type header for the response.
     */
    private string $contentType;

    /**
     * @var string The encoding for the Content-Type header.
     */
    private string $encoding = 'UTF-8';

    public function __construct(Resource $resource)
    {
        $this->contentType = $resource->getContentType();
    }

    /**
     * @inheritDoc
     */
    public function format(DataResponse $dataResponse): ResponseInterface
    {
        /** @psalm-suppress MixedArgument */
        return $this->addToResponse($dataResponse->getResponse(), $dataResponse->getData() ?? null);
    }
}
