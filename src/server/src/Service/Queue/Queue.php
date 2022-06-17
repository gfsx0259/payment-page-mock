<?php

namespace App\Service\Queue;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use Exception;
use Yiisoft\Injector\Injector;

class Queue implements QueueInterface
{
    private Client $client;

    private Injector $injector;

    private array $config;

    private array $credentials;

    private const JOB_CLASS_NAME = 'className';

    private const JOB_DATA = 'data';

    public function __construct(Injector $injector, array $credentials, array $config)
    {
        $this->injector = $injector;
        $this->credentials = $credentials;
        $this->config = $config;
        $this->client = $this->makeClient();
    }

    public function subscribe(string $queueName, ?callable $callback = null): void
    {
        $chanel = $this->makeChanel($queueName);
        $injector = $this->injector;

        $chanel->run(
            function (Message $message, Channel $channel, Client $bunny) use ($injector, $callback) {
                $content = json_decode($message->content, true);
                $jobClassName = $content[self::JOB_CLASS_NAME];
                $jobData = $content[self::JOB_DATA];

                /** @var JobInterface $job */
                $job = $injector->make($jobClassName);

                $job->initFromString($jobData);

                try {
                    $success = true;

                    $job->run();
                } catch (Exception $exception) {
                    $success = false;
                }

                if ($success) {
                    $channel->ack($message);
                } else {
                    $channel->nack($message);
                }

                if ($callback) {
                    $callback($success, $job);
                }
            },
            $queueName
        );
    }

    public function send(string $jobClass, array $params = []): void
    {
        $job = $this->makeJob($jobClass, $params);
        $delay = $job->getDelay();
        $queueName = $this->getQueueName($jobClass);
        $chanel = $this->makeChanel($queueName);
        $destinationQueueName = $delay ? $this->declareDelayedQueue($chanel, $queueName, $delay) : $queueName;

        $chanel->publish(
            json_encode([
                self::JOB_CLASS_NAME => $job::class,
                self::JOB_DATA => $job->serialize()
            ]),
            [],
            '',
            $destinationQueueName
        );
    }

    private function getQueueName(string $jobClass): string
    {
        foreach ($this->config as $queueConfig) {
            if (in_array($jobClass, $queueConfig['jobs'])) {
                return $queueConfig['name'];
            }
        }

        throw new Exception('Unknown job. Please define it in config/params.php');
    }

    private function makeJob(string $jobClass, array $params): JobInterface
    {
        $job = $this->injector->make($jobClass);

        if (!($job instanceof JobInterface)) {
            throw new Exception('Job class must implement JobInterface');
        }

        foreach ($params as $key => $value) {
            $job->$key = $value;
        }

        return $job;
    }

    private function declareDelayedQueue(Channel $channel, string $queueName, int $delay): string
    {
        $delayedQueueName = "$queueName-$delay";

        $channel->queueDeclare(
            $delayedQueueName,
            false,
            false,
            false,
            true,
            false,
            [
                # set the dead-letter exchange to the default queue
                'x-dead-letter-exchange' => '',
                # when the message expires, set change the routing key into the destination queue name
                'x-dead-letter-routing-key' => $queueName,
                # the time in milliseconds to keep the message in the queue
                'x-message-ttl' => $delay
            ]
        );

        return $delayedQueueName;
    }

    private function makeChanel(string $queueName): Channel
    {
        $chanel = $this->client->channel();

        $chanel->queueDeclare($queueName);

        return $chanel;
    }

    private function makeClient(): Client
    {
        $client = new Client($this->credentials);

        $client->connect();

        return $client;
    }
}
