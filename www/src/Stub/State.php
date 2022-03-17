<?php

namespace App\Stub;

class State
{
    private string $requestId;
    private string $route;
    private int $count = 0;

    /**
     * @param string $requestId
     * @param string $route
     */
    public function __construct(string $requestId, string $route)
    {
        $this->requestId = $requestId;
        $this->route = $route;
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function increaseCount(): self
    {
        $this->count += 1;

        return $this;
    }
}
