<?php

declare(strict_types=1);

namespace App\Stub;

use App\Stub\Form\AcsRequestForm;
use App\Stub\Session\StateManager;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Yii\View\ViewRenderer;

final class ActionController
{
    private ViewRenderer $viewRenderer;
    private DataResponseFactoryInterface $responseFactory;

    public function __construct(
        ViewRenderer $viewRenderer,
        DataResponseFactoryInterface $responseFactory
    ) {
        $this->viewRenderer = $viewRenderer
            ->withControllerName('stub/action')
            ->withLayout(null);
        $this->responseFactory = $responseFactory;
    }

    public function renderAcs(
        ServerRequestInterface $request,
        ValidatorInterface $validator
    ): ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        $form = new AcsRequestForm();

        $form->load((array)$requestBody) && $validator->validate($form);

        return $this->viewRenderer->render('acsPage', ['form' => $form]);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function completeAcs(
        ServerRequestInterface $request,
        StateManager $stateManager,
    ): ResponseInterface
    {
        $body = json_decode($request->getBody()->getContents());

        if (!$state = $stateManager->get(ArrayHelper::getValueByPath($body, 'general.payment_id'))) {
            throw new LogicException('State must be exists');
        }

        $state->completeAction(ArrayHelper::getValueByPath($body, 'md'));

        $stateManager->save($state);

        return $this->responseFactory->createResponse();
    }
}
