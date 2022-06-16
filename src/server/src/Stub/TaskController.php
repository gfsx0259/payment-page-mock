<?php

declare(strict_types=1);

namespace App\Stub;

use App\Service\WebControllerService;
use App\Stub\Service\PaymentListener;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Safe\Exceptions\StringsException;

final class TaskController
{
    public function __construct(
        private PaymentListener $paymentListener,
    ) {}

    /**
     * @throws StringsException
     * @throws InvalidArgumentException
     */
    public function scheduleCallbacks(
        WebControllerService $controllerService
    ): ResponseInterface
    {
        $this->paymentListener->listen();

        return $controllerService->getEmptySuccessResponse();
    }
}
