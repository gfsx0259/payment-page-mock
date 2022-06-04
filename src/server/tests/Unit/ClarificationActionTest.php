<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Action\ClarificationAction;
use App\Stub\Session\State;
use App\Tests\UnitTester;
use Codeception\Test\Unit;

final class ClarificationActionTest extends Unit
{
    protected UnitTester $tester;
    private const LEGACY = 'legacy';
    private const SCHEMA = 'schema';
    private const SENT = 'sent';
    private const MOCKS = [
        self::LEGACY => ['clarification_fields' => ['avs_data' => ['avs_post_code', 'avs_street_address']]],
        self::SCHEMA => [
            'clarification_fields' => [
                'avs_data' => [
                    'type' => 'array',
                    'properties' => [
                        'avs_post_code' => ['description' => 'some'],
                        'avs_street_address' => ['description' => 'some']
                    ]
                ]
            ]
        ],
        self::SENT => [
            'additional_data' => [
                'avs_data' => [
                    'avs_post_code' => '32134',
                    'avs_street_address' => 'Ddsa'
                ]
            ]
        ],
    ];

    public function testGettingActionKey(): void
    {
        $callbacks = [
            self::MOCKS[self::LEGACY],
            self::MOCKS[self::SCHEMA],
        ];

        foreach ($callbacks as $data) {
            $state = $this->tester->makeState();
            $action = $this->makeAction($data, $state);
            $expectingActionKey = $this->getActionKey();

            $this->tester->checkGettingActionKey($action, $expectingActionKey, self::MOCKS[self::SENT]);
        }
    }

    public function testRegistering(): void
    {
        $state = $this->tester->makeState();
        $action = $this->makeAction(self::MOCKS[self::LEGACY], $state);
        $expectingKey = $this->getActionKey();

        $this->tester->checkRegistering($action, $state, $expectingKey, self::MOCKS[self::SENT]);
    }

    public function testCompleting(): void
    {
        $state = $this->tester->makeState();
        $action = $this->makeAction(self::MOCKS[self::SCHEMA], $state);
        $expectingKey = $this->getActionKey();

        $this->tester->checkCompleting($action, $state, $expectingKey, self::MOCKS[self::SENT]);
    }

    private function getActionKey(): string
    {
        return md5(implode(',', ['avs_data.avs_post_code', 'avs_data.avs_street_address']));
    }

    private function makeAction(array $data, State $state): ClarificationAction
    {
        $collection = new ArrayCollection($data);

        return new ClarificationAction($collection, $state);
    }
}
