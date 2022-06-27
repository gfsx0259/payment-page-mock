<?php

namespace App\Stub\Job;

use App\Service\Queue\AbstractJob;
use App\Stub\Service\Callback\CallbackProcessor;
use App\Stub\Service\Callback\CallbackResolver;
use App\Stub\Service\Callback\CallbackSender;
use App\Stub\Session\StateManager;

class SendCallbackJob extends AbstractJob
{
    public string $requestId;

    public function __construct(
        private StateManager $stateManager,
        private CallbackSender $callbackSender,
        private CallbackResolver $callbackResolver,
        private CallbackProcessor $callbackProcessor
    ) {}

    /**
     * @inheritDoc
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function run(): void
    {
        $state = $this->stateManager->get($this->requestId);
        $callback = $this->callbackResolver->resolve($state);

        $this->callbackSender->send(
            $this->callbackProcessor->process($state, $callback)
        );
    }
}
