<?php

namespace App\Stub\Service;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\AbstractAction;
use App\Stub\Service\Action\AcsAction;
use App\Stub\Service\Action\ActionInterface;
use App\Stub\Service\Action\ApsAction;
use App\Stub\Service\Action\ClarificationAction;
use App\Stub\Service\Action\CompositeAction;
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
    ) {
    }

    public function make(ArrayCollection $callback, State $state): ?ActionInterface
    {
        try {
            if ($callback->get('acs')) {
                return new AcsAction($callback, $state);
            } elseif ($callback->get('return_url.url')) {
                return $this->injector->make(ApsAction::class, [$callback, $state]);
            } elseif ($callback->get('clarification_fields')) {
                return new ClarificationAction($callback, $state);
            } elseif (is_array($callback->get('display_data'))) {
                return $this->makeDisplayDataAction($callback, $state);
            }
        } catch (ReflectionException | ContainerExceptionInterface $exception) {
            $this->logger->error($exception->getMessage());
            return null;
        }

        return null;
    }

    private function makeDisplayDataAction(ArrayCollection $callback, State $state): ActionInterface
    {
        $displayData = $callback->get('display_data');
        $actions = [];

        foreach ($displayData as $i => $data) {
            $dataCollection = new ArrayCollection($data);

            if ($dataCollection->get('type') === QrCodeAction::DISPLAY_DATA_TYPE) {
                $actions[] = new QrCodeAction($callback, $state, (int) $i);
            }
        }

        return new CompositeAction($actions);
    }
}
