<?php

declare(strict_types=1);

namespace App\Command\Queue;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Yii\Console\ExitCode;

final class ListenAllCommand extends Command
{
    private array $params;

    protected static $defaultName = 'queue/listen-all';

    public function __construct(array $params)
    {
        $this->params = $params;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Consume messages from all defined queues')
            ->setHelp('This command runs listening messages from all defined queues.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->params as $queueConfig) {
            $queueName = $queueConfig['name'];

            exec("php yii queue/listen $queueName >/dev/null 2>&1 &");
            $output->writeln("Queue `$queueName` is listening");
        }

        return ExitCode::OK;
    }
}
