<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Entity\Callback;
use App\Stub\Job\SendCallbackJob;
use App\Stub\Service\Callback\CallbackProcessor;
use App\Stub\Service\Callback\CallbackResolver;
use App\Stub\Service\Callback\CallbackSender;
use App\Stub\Session\State;
use App\Stub\Session\StateManager;
use App\Tests\UnitTester;
use Codeception\Test\Unit;

final class SendCallbackJobTest extends Unit
{
    protected UnitTester $tester;

    private const CALLBACK = ['some_test_key' => 'some_test_value'];

    public function testRun(): void
    {
        $state = $this->tester->makeState();
        $cursor = $state->getCursor();

        $correctCallbackSent = false;

        $sendCallbackJob = new SendCallbackJob(
            $this->make(StateManager::class, [
                'get' => function (string $requestId) use ($state) {
                    return $state->getRequestId() === $requestId ? $state : null;
                }
            ]),
            $this->make(CallbackSender::class, [
                'send' => function (ArrayCollection $callback) use (&$correctCallbackSent) {
                    $correctCallbackSent = $callback->data === self::CALLBACK;
                }
            ]),
            $this->make(CallbackResolver::class, [
                'resolve' => function (State $state) use ($cursor) {
                    if ($state->getCursor() === $cursor) {
                        return new Callback(1, json_encode(self::CALLBACK), $cursor);
                    }

                    return new Callback(2, json_encode(['invalid callback']), $state->getCursor());
                }
            ]),
            $this->make(CallbackProcessor::class, [
                'process' => function (State $state, Callback $callback) {
                    return new ArrayCollection($callback->getBody());
                }
            ])
        );

        $sendCallbackJob->requestId = $state->getRequestId();

        $sendCallbackJob->run();

        $this->assertTrue($correctCallbackSent, 'CallbackSender has got invalid callback to send');
    }

    public function testDelay(): void
    {
        $job = $this->make(SendCallbackJob::class);

        $this->assertEquals($job->getDelay(), 0, 'Default job delay should be equal to 0');

        $job->delay = 1000;

        $this->assertEquals($job->getDelay(), 1000, 'Job must have a possibility to change delay');
    }

    public function testSerialization(): void
    {
        $job = new SendCallbackJob(
            $this->make(StateManager::class),
            $this->make(CallbackSender::class),
            $this->make(CallbackResolver::class),
            $this->make(CallbackProcessor::class)
        );

        $testData = ['requestId' => 'jf234Jh54j@#$5%', 'delay' => 123456];

        foreach ($testData as $property => $value) {
            $job->$property = $value;
        }

        $this->assertEquals(
            json_decode($job->serialize(), true),
            $testData,
            'Data to send in a queue is not equal to expected'
        );
    }

    public function testInitFromString(): void
    {
        $job = new SendCallbackJob(
            $this->make(StateManager::class),
            $this->make(CallbackSender::class),
            $this->make(CallbackResolver::class),
            $this->make(CallbackProcessor::class)
        );

        $testData = ['requestId' => 'jf234Jh54j@#$5%', 'delay' => 123456];

        $job->unserialize(json_encode($testData));

        $this->assertEquals($job->requestId, $testData['requestId'], 'requestId has not been set');
        $this->assertEquals($job->delay, $testData['delay'], 'delay has not been set');
    }
}
