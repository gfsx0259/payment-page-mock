<?php

namespace App\Stub\Service;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\AbstractAction;
use App\Stub\Service\Action\AcsAction;
use App\Stub\Service\Action\ApsAction;
use App\Stub\Service\Action\ApsWidgetAction;
use App\Stub\Service\Action\ClarificationAction;
use App\Stub\Service\Action\QrCodeAction;
use App\Stub\Session\State;
use Psr\Container\ContainerExceptionInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Yiisoft\Injector\Injector;

class ActionFactory
{
    public function __construct(
        private Injector $injector,
        private LoggerInterface $logger
    ) {}

    public function make(ArrayCollection $callback, State $state): ?AbstractAction
    {
        try {
            if ($callback->get('acs')) {
                return new AcsAction($callback, $state);
            } elseif ($callback->get('return_url.url')) {
                if ($callback->get('return_url.body.callback_url')) {
                    return $this->injector->make(ApsWidgetAction::class, [$callback, $state]);
                } else {
                    return $this->injector->make(ApsAction::class, [$callback, $state]);
                }
            } elseif ($callback->get('clarification_fields')) {
                return new ClarificationAction($callback, $state);
            } elseif ($callback->get('display_data.0.type') === QrCodeAction::DISPLAY_DATA_TYPE_RAW) {
                return $this->injector->make(QrCodeAction::class, [$callback, $state]);
            }
        } catch (ReflectionException | ContainerExceptionInterface $exception) {
            $this->logger->error($exception->getMessage());
        }

        return null;
    }
}
