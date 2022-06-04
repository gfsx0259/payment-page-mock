<?php

declare(strict_types=1);

namespace App\Stub;

use App\Stub\Form\AcsRequestForm;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Yii\View\ViewRenderer;

final class DummyPageController
{
    public function __construct(
        private ViewRenderer $viewRenderer,
        private UrlGeneratorInterface $urlGenerator,
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
}
