<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\ApsAction;
use App\Stub\Service\UrlHelper;
use App\Stub\Session\State;
use App\Tests\UnitTester;
use Codeception\Test\Unit;

final class ApsActionTest extends Unit
{
    protected UnitTester $tester;
    private const IDENTITY_KEY = 'KfjUEun32u!3$@';
    private const CALLBACK = ['return_url' => ['url' => 'http://localhost/actions/renderAps/' . self::IDENTITY_KEY]];
    private const COMPLETE_REQUEST = ['uniqueKey' => self::IDENTITY_KEY];

    public function testGettingActionKey(): void
    {
        $state = $this->tester->makeState();
        $actionWithRedirectUrl = $this->makeAction($state);
        $expectingActionKey = self::IDENTITY_KEY;

        $this->tester->checkGettingActionKey($actionWithRedirectUrl, $expectingActionKey, self::COMPLETE_REQUEST);
    }

    public function testNoRedirectUrlHandling(): void
    {
        $state = $this->tester->makeState();
        $action = $this->makeAction($state, ['return_url' => ['url' => 'test']]);

        $this->assertNotEquals(
            $action->getActionKey(),
            $action->getActionKey()
        );
    }

    public function testRegistering(): void
    {
        $state = $this->tester->makeState();
        $action = $this->makeAction($state);
        $expectingKey = self::IDENTITY_KEY;

        $this->tester->checkRegistering($action, $state, $expectingKey, self::COMPLETE_REQUEST);
    }

    public function testCompleting(): void
    {
        $state = $this->tester->makeState();
        $action = $this->makeAction($state);
        $expectingKey = self::IDENTITY_KEY;

        $this->tester->checkCompleting($action, $state, $expectingKey, self::COMPLETE_REQUEST);
    }

    private function makeAction(State $state, array $callback = self::CALLBACK): ApsAction
    {
        $collection = new ArrayCollection($callback);

        return new ApsAction($collection, $state, $this->tester->makeByAppContainer(UrlHelper::class));
    }
}
