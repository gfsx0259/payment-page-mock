<?php

namespace App\Service\Queue;

use Cycle\ORM\ORMInterface;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use ReflectionException;
use Yiisoft\Injector\Injector;
use Psr\Log\LoggerInterface;

/**
 * This queue uses rabbitmq as remote server
 */
class Queue implements QueueInterface
{
    private const
        JOB_CLASS_NAME = 'className',
        JOB_DATA = 'data';

    public function __construct(
        private BrokerInterface $broker,
        private Injector $injector,
        private LoggerInterface $logger,
        private ORMInterface $orm,
        private array $mapping
    ) {}

    /**
     * @inheritDoc
     *
     * Injects all needed parameters to constructor of job from global DI container
     */
    public function subscribe(string $queueName, ?callable $callback = null): void
    {
        $this->broker->listen(
            $queueName,
            function (string $message) use ($callback): bool {
                $content = json_decode($message, true);
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

                if ($callback) {
                    $callback($success, $job);
                }

                $this->orm->getHeap()->clean();

                return $success;
            }
        );
    }

    /**
     * @inheritDoc
     */
    public function push(string $jobClass, array $params = []): void
    {
        $job = $this->makeJob($jobClass, $params);
        $message = json_encode([
            self::JOB_CLASS_NAME => $job::class,
            self::JOB_DATA => $job->serialize()
        ]);

        $this->broker->send(
            $this->getQueueName($jobClass),
            $message,
            [
                'delay' => $job->getDelay()
            ]
        );
    }

    /**
     * @param string $jobClass
     * @return string
     * @throws QueueException
     */
    private function getQueueName(string $jobClass): string
    {
        foreach ($this->mapping as $route) {
            if (in_array($jobClass, $route['jobs'])) {
                return $route['queue_name'];
            }
        }

        throw new QueueException("Unknown job ($jobClass). Please define it in config/common/queue.php");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
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

    /**
     * @inheritDoc
     */
    public function checkConnection(): bool
    {
        return $this->broker->checkConnection();
    }
}
