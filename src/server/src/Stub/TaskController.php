<?php

declare(strict_types=1);

namespace App\Stub;

use App\Service\WebControllerService;
use App\Stub\Service\PaymentListener;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Loop;

final class TaskController
{
    private const SEND_CALLBACK_PERIOD_SECONDS = 3;

    public function __construct(
        private Loop $loop,
        private PaymentListener $paymentListener,
    ) {}

    public function scheduleCallbacks(
        WebControllerService $controllerService
    ): ResponseInterface
    {
        $this->loop::get()->addPeriodicTimer(
            self::SEND_CALLBACK_PERIOD_SECONDS,
            [$this->paymentListener, 'listen']
        );

        return $controllerService->getEmptySuccessResponse();
    }
}
