<?php

declare(strict_types=1);

namespace App\Stub;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Form\AcsRequestForm;
use App\Stub\Service\Callback\CallbackResolver;
use App\Stub\Session\StateManager;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Yii\View\ViewRenderer;
use Psr\SimpleCache\InvalidArgumentException;

final class DummyPageController
{
    public function __construct(
        private ViewRenderer $viewRenderer,
        private UrlGeneratorInterface $urlGenerator,
        private CallbackResolver $callbackResolver,
        private StateManager $stateManager,
    ) {
        $this->viewRenderer = $viewRenderer
            ->withControllerName('stub/dummy')
            ->withLayout(null);
    }

    public function renderAcs(
        ServerRequestInterface $request,
        ValidatorInterface $validator
    ): ResponseInterface {
        $requestBody = $request->getParsedBody();
        $form = new AcsRequestForm();

        $form->load((array)$requestBody) && $validator->validate($form);

        return $this->viewRenderer->render('acsPage', ['form' => $form]);
    }

    public function renderAps(
        CurrentRoute $currentRoute,
    ): ResponseInterface {
        return $this->viewRenderer->render('apsPage', [
            'completeUrl' => $this->urlGenerator->generate('actions/completeAps'),
            'uniqueKey' => $currentRoute->getArgument('uniqueKey'),
        ]);
    }

    public function renderConfirmationQr(
        CurrentRoute $currentRoute,
    ): ResponseInterface {
        return $this->viewRenderer->render('confirmationQrPage', [
            'completeUrl' => $this->urlGenerator->generate('actions/completeConfirmationQr'),
            'uniqueKey' => $currentRoute->getArgument('uniqueKey'),
        ]);
    }

    /**
     * First step of 3ds 2.0 check
     * This page emulates getting callback from ACS
     * That means customer needs to pass 3ds 2.0 check
     *
     * @param CurrentRoute $currentRoute
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function renderAcsIframe(CurrentRoute $currentRoute, ServerRequestInterface $request): ResponseInterface
    {
        if (!$state = $this->stateManager->get($currentRoute->getArgument('uniqueKey'))) {
            throw new LogicException('State must be exists');
        }

        $callback = new ArrayCollection($this->callbackResolver->resolve($state)->getBody());
        $expectedBody = $callback->get('threeds2.iframe.params');
        $body = $request->getParsedBody();

        if ($expectedBody !== $body) {
            throw new LogicException('Expected body: ' . json_encode($expectedBody));
        }

        $operationId = rand(1, 10000000);
        $actionUrl = $state->getInitialRequest()->get('acs_return_url.3ds_notification_url')
            . "&operation_id=$operationId";

        return $this->viewRenderer->render('acsIframePage', ['actionUrl' => $actionUrl]);
    }

    /**
     * Second step of 3ds 2.0 check
     * This page emulates getting confirmation code from customer
     *
     * @param CurrentRoute $currentRoute
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function renderAcsRedirect(CurrentRoute $currentRoute, ServerRequestInterface $request): ResponseInterface
    {
        $uniqueKey = $currentRoute->getArgument('uniqueKey');

        if (!$state = $this->stateManager->get($uniqueKey)) {
            throw new LogicException('State must be exists');
        }

        $operationId = rand(1, 10000000);
        $actionUrl = $state->getInitialRequest()->get('acs_return_url.return_url') . "?operation_id=$operationId";
        $callback = new ArrayCollection($this->callbackResolver->resolve($state)->getBody());
        $expectedBody = $callback->get('threeds2.redirect.params');
        $body = $request->getParsedBody();

        if ($expectedBody !== $body) {
            throw new LogicException('Expected body: ' . json_encode($expectedBody));
        }

        return $this->viewRenderer->render('acsRedirectPage', ['actionUrl' => $actionUrl]);
    }
}
