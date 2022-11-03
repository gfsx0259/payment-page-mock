<?php

namespace App\Stub\Service;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\AbstractAction;
use App\Stub\Service\Action\AcsAction;
use App\Stub\Service\Action\ApsAction;
use App\Stub\Service\Action\ApsWidgetAction;
use App\Stub\Service\Action\ClarificationAction;
use App\Stub\Service\Action\QrDataAction;
use App\Stub\Service\Action\QrImageAction;
use App\Stub\Service\Action\PaymentAction;
use App\Stub\Session\State;
use Psr\Container\ContainerExceptionInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Yiisoft\Injector\Injector;

class ActionFactory
{
    private const
        DISPLAY_DATA_TYPE_RAW = 'qr_data',
        DISPLAY_DATA_TYPE_IMG = 'qr_img';

    public function __construct(
        private Injector $injector,
        private LoggerInterface $logger
    ) {}

    public function make(ArrayCollection $callback, State $state): ?AbstractAction
    {
        $this->logger->info('Try to create action', [
            'callback' => $callback,
            'state' => $state,
        ]);

        try {
            if ($paReq = $callback->get('acs.pa_req')) {
                $isProxyFlow = isset(json_decode(base64_decode($paReq))->threeds2);

                return $isProxyFlow
                    ? $this->injector->make(PaymentAction::class, [$callback, $state])
                    : $this->injector->make(AcsAction::class, [$callback, $state]);

            } elseif ($callback->get('threeds2.iframe.url')) {
                return $this->injector->make(PaymentAction::class, [$callback, $state]);
            } elseif ($callback->get('threeds2.redirect.url')) {
                return $this->injector->make(PaymentAction::class, [$callback, $state]);
            } elseif ($callback->get('return_url.url')) {
                if ($callback->get('return_url.body.callback_url')) {
                    return $this->injector->make(ApsWidgetAction::class, [$callback, $state]);
                } else {
                    return $this->injector->make(ApsAction::class, [$callback, $state]);
                }
            } elseif ($callback->get('clarification_fields')) {
                return new ClarificationAction($callback, $state);
            } elseif ($callback->get('display_data.0.type') === self::DISPLAY_DATA_TYPE_RAW) {
                return $this->injector->make(QrDataAction::class, [$callback, $state]);
            } elseif ($callback->get('display_data.0.type') === self::DISPLAY_DATA_TYPE_IMG) {
                return $this->injector->make(QrImageAction::class, [$callback, $state]);
            }
        } catch (ReflectionException | ContainerExceptionInterface $exception) {
            $this->logger->error($exception->getMessage());
        }

        return null;
    }
}
