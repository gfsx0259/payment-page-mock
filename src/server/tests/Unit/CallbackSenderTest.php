<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Service\Callback\CallbackSender;
use Codeception\Test\Unit;
use Exception;
use GuzzleHttp\Client;
use itechpsp\SignatureHandler;
use Psr\Log\LoggerInterface;

final class CallbackSenderTest extends Unit
{
    private const CALLBACK = ['some_test_key' => 'some_test_value'];
    private const TEST_SECRET_KEY = 'frtrt32';

    public function testSuccessSending(): void
    {
        $signature = (new SignatureHandler(self::TEST_SECRET_KEY))->sign(self::CALLBACK);
        $expectedJson = array_merge(['general' => ['signature' => $signature]], self::CALLBACK);

        $sentAtEndpoint = null;
        $sentJson = null;

        $stubCallbackSender = $this->make(CallbackSender::class, [
            'logger' => $this->makeEmpty(LoggerInterface::class),
            'secret' => self::TEST_SECRET_KEY,
            'httpClient' => $this->make(Client::class, [
                'post' => function (string $uri, array $params) use (&$sentAtEndpoint, &$sentJson) {
                    $sentAtEndpoint = $uri;
                    $sentJson = $params['json'];
                }
            ]),
        ]);

        $stubCallbackSender->send(new ArrayCollection(self::CALLBACK));

        $this->assertEquals('callbacks', $sentAtEndpoint);
        $this->assertEquals($expectedJson, $sentJson);
    }

    public function testErrorResponseHandling(): void
    {
        $exception = new Exception('Something went wrong');
        $loggedMessage = null;
        $stubCallbackSender = $this->make(CallbackSender::class, [
            'secret' => self::TEST_SECRET_KEY,
            'logger' => $this->makeEmpty(LoggerInterface::class, [
                'error' => function (string $message) use (&$loggedMessage) {
                    $loggedMessage = $message;
                }
            ]),
            'httpClient' => $this->make(Client::class, [
                'post' => function (string $uri, array $params) use (&$exception) {
                    throw $exception;
                }
            ]),
        ]);

        $stubCallbackSender->send(new ArrayCollection(self::CALLBACK));

        $this->assertEquals($exception->getMessage(), $loggedMessage);
    }
}
