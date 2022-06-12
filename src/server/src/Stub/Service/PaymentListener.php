<?php

namespace App\Stub\Service;

use App\Stub\Entity\Request;
use App\Stub\Repository\RequestRepository;
use App\Stub\Session\StateManager;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Safe\Exceptions\StringsException;
use Yiisoft\Arrays\ArrayHelper;
use function Safe\sprintf;

class PaymentListener
{
    public function __construct(
        private LoggerInterface $logger,
        private StateManager $stateManager,
        private RequestRepository $requestRepository,
        private PaymentService $requestService,
        private CallbackResolver $callbackResolver,
        private CallbackProcessor $callbackProcessor,
        private CallbackSender $callbackSender
    ) {}

    /**
     * @throws StringsException
     * @throws InvalidArgumentException
     */
    public function listen(): void
    {
        $requests = $this->requestRepository->findActual();

        if (!count($requests)) {
            $this->logger->info('Requests not found, abort');
        }

        $this->logger->info(sprintf('Found %s requests, process it', count($requests)));

        foreach ($requests as $request) {
            $this->compareStatus($request);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private function compareStatus(Request $request): void
    {
        $state = $this->stateManager->get($request->getRequestId());
        $callback = $this->callbackResolver->resolve($state);

        if (!$callbackStatus = ArrayHelper::getValue($callback->getBody(), 'payment.status')) {
            $this->logger->warning('Can not parse payment status from callback', $callback->getBody());
            return;
        }

        if ($callbackStatus !== $request->getStatus()) {
            $this->requestService->updateStatus($request, $callbackStatus);
            $this->callbackSender->send(
                $this->callbackProcessor->process($state, $callback)
            );
        }
    }
}
