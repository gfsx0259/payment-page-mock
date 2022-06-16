<?php

namespace App\Stub\Service;

use App\Stub\Entity\Request;
use App\Stub\Session\State;
use Psr\Log\LoggerInterface;
use Throwable;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

class PaymentService
{
    public function __construct(
        private EntityWriter $entityWriter,
        private LoggerInterface $logger,
    ) {}

    public function register(State $state): void
    {
        try {
            $this->entityWriter->write([new Request($state->getRequestId())]);
        } catch (Throwable $exception) {
            $this->logger->error("Can not register request: {$exception->getMessage()}");
        }
    }

    public function updateStatus(Request $request, string $status): void
    {
        try {
            $request->setStatus($status);
            $this->entityWriter->write([$request]);
        } catch (Throwable $exception) {
            $this->logger->error("Can not save payment status: {$exception->getMessage()}");
        }
    }
}
