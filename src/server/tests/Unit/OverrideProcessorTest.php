<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Service\QrGenerator;
use App\Stub\Collection\ArrayCollection;
use App\Stub\Repository\ResourceRepository;
use App\Stub\Service\Callback\OverrideProcessor;
use App\Stub\Session\StateManager;
use App\Tests\UnitTester;
use Codeception\Test\Unit;
use Exception;
use Psr\Log\LoggerInterface;
use Yiisoft\Router\UrlGeneratorInterface;

final class OverrideProcessorTest extends Unit
{
    protected UnitTester $tester;

    private const CALLBACK = [
        'request_id' => '{{REQUEST_ID}}',
        'acs' => [
            'pa_req' => [
                'threeds2' => [
                    'iframe' => [
                        'url' => 'https://enthusiasts.com',
                        'params' => ['3DSMethodData' => '16589104951172', 'threeDSMethodData' => '16589104951172'],
                    ],
                ],
            ],
        ],
        '@' => [
            'filters' => [
                ['action' => 'base64', 'path' => 'acs.pa_req'],
            ],
        ],
    ];

    /**
     * @throws Exception
     */
    public function testProcessReplace(): void
    {
        $state = $this->tester->makeState();

        $processor = $this->factoryOverrideProcessor();
        $callback = $processor->process(
            new ArrayCollection(self::CALLBACK),
            $state
        );

        $this->assertEquals(
            $state->getRequestId(),
            $callback->get('request_id')
        );
    }

    /**
     * @throws Exception
     */
    public function testProcessFilter(): void
    {
        $state = $this->tester->makeState();

        $processor = $this->factoryOverrideProcessor();
        $callback = $processor->process(
            new ArrayCollection(self::CALLBACK),
            $state
        );

        $expectedPaReq = base64_encode(\Safe\json_encode(self::CALLBACK['acs']['pa_req']));

        $this->assertEquals(
            $expectedPaReq,
            $callback->get('acs.pa_req')
        );
    }

    /**
     * @throws Exception
     */
    private function factoryOverrideProcessor(): OverrideProcessor {
        return new OverrideProcessor(
            $this->makeEmpty(UrlGeneratorInterface::class),
            $this->make(ResourceRepository::class, ['findAll' => []]),
            $this->make(StateManager::class, ['generateAccessKey' => '']),
            $this->make(QrGenerator::class),
            $this->makeEmpty(LoggerInterface::class),
            'host'
        );
    }
}
