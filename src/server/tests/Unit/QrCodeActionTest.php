<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\QrCodeAction;
use App\Service\RouteMatcher;
use App\Stub\Service\ActionException;
use App\Stub\Session\State;
use App\Tests\UnitTester;
use Codeception\Test\Unit;
use Exception;

final class QrCodeActionTest extends Unit
{
    protected UnitTester $tester;
    private const IDENTITY_KEY = '3243JhrfUW!@$2';
    private const COMPLETE_REQUEST = ['uniqueKey' => self::IDENTITY_KEY];
    private const CALLBACK = [
        'display_data' => [
            ['data' => 'http://localhost/actions/renderConfirmationViaQrCode/' . self::IDENTITY_KEY],
        ]
    ];

    public function testGettingActionKey(): void
    {
        $state = $this->tester->makeState();
        $expectingActionKey = self::IDENTITY_KEY;
        $actionWithRedirectUrl = $this->makeAction($state, $expectingActionKey);

        $this->tester->checkGettingActionKey($actionWithRedirectUrl, $expectingActionKey, self::COMPLETE_REQUEST);
    }

    public function testNoRedirectUrlHandling(): void
    {
        $state = $this->tester->makeState();
        $action = $this->makeAction($state, null, ['display_data' => [['data' => 'test']]]);
        $expectedException = null;

        try {
            $action->getActionKey();
        } catch (Exception $exception) {
            $expectedException = $exception;
        }

        $this->assertInstanceOf(ActionException::class, $expectedException);
    }

    public function testRegistering(): void
    {
        $state = $this->tester->makeState();
        $expectingKey = self::IDENTITY_KEY;
        $action = $this->makeAction($state, $expectingKey);

        $this->tester->checkRegistering($action, $state, $expectingKey, self::COMPLETE_REQUEST);
    }

    public function testCompleting(): void
    {
        $state = $this->tester->makeState();
        $expectingKey = self::IDENTITY_KEY;
        $action = $this->makeAction($state, $expectingKey);

        $this->tester->checkCompleting($action, $state, $expectingKey, self::COMPLETE_REQUEST);
    }

    private function makeAction(
        State $state,
        ?string $expectingKey = null,
        array $callback = self::CALLBACK
    ): QrCodeAction {
        $that = $this;
        $collection = new ArrayCollection($callback);
        $routeMatcher = $this->make(RouteMatcher::class, [
            'parseArgument' => function ($url, $key) use ($collection, $expectingKey, $that) {
                $that->assertEquals($url, $collection->get('display_data.0.data'));
                $that->assertEquals($key, 'uniqueKey');

                return $expectingKey;
            }
        ]);

        return new QrCodeAction($collection, $state, $routeMatcher);
    }
}
