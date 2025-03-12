<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Safe\Exceptions\JsonException;
use Yiisoft\Http\Header;

final class ApiRequestParser implements MiddlewareInterface
{
    /**
     * @throws JsonException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (str_contains($request->getHeader(Header::CONTENT_TYPE)[0], 'application/json')) {
            $request = $request->withParsedBody(\Safe\json_decode($request->getBody()->getContents(), true));
        }

        return $handler->handle($request);
    }
}
