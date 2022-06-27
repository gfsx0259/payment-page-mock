<?php

namespace App\Service\Queue;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use Exception;
use Yiisoft\Injector\Injector;
use Psr\Log\LoggerInterface;

/**
 * This queue uses rabbitmq as remote server
 */
class Queue implements QueueInterface
{
    private Client $client;

    private Injector $injector;

    private LoggerInterface $logger;

    private array $config;

    private const JOB_CLASS_NAME = 'className';

    private const JOB_DATA = 'data';

    public function __construct(Client $client, Injector $injector, LoggerInterface $logger, array $config)
    {
        $this->injector = $injector;
        $this->logger = $logger;
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @inheritDoc
     *
     * Injects all needed parameters to constructor of job from global DI container
     */
    public function subscribe(string $queueName, ?callable $callback = null): void
    {
        $chanel = $this->makeChanel($queueName);

        $chanel->run(
            function (Message $message, Channel $channel) use ($callback) {
                $content = json_decode($message->content, true);
                $jobClassName = $content[self::JOB_CLASS_NAME];
                $jobData = $content[self::JOB_DATA];

                /** @var JobInterface $job */
                $job = $this->injector->make($jobClassName);

                $job->unserialize($jobData);

                try {
                    $success = true;

                    $job->run();
                } catch (Exception $exception) {
                    $success = false;

                    $this->logger->error($exception->getMessage());
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

    /**
     * @inheritDoc
     */
    public function push(string $jobClass, array $params = []): void
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

    /**
     * @inheritDoc
     */
    public function checkConnection(): bool
    {
        if (!$this->client->isConnected()) {
            try {
                $this->client->connect();
            } catch (Exception $exception) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $jobClass
     * @return string
     * @throws QueueException
     */
    private function getQueueName(string $jobClass): string
    {
        foreach ($this->config as $queueConfig) {
            if (in_array($jobClass, $queueConfig['jobs'])) {
                return $queueConfig['name'];
            }
        }

        throw new QueueException("Unknown job ($jobClass). Please define it in config/params.php");
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \ReflectionException
     * @throws QueueException
     */
    private function makeJob(string $jobClass, array $params): JobInterface
    {
        $job = $this->injector->make($jobClass);

        if (!($job instanceof JobInterface)) {
            throw new QueueException("Job class `$jobClass` must implement JobInterface");
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
        if (!$this->client->isConnected()) {
            $this->client->connect();
        }

        $chanel = $this->client->channel();

        $chanel->queueDeclare($queueName);

        return $chanel;
    }
}
