<?php

declare(strict_types=1);

namespace App\Command\Queue;

use App\Service\Queue\JobInterface;
use App\Service\Queue\QueueInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Yii\Console\ExitCode;

final class ListenCommand extends Command
{
    private QueueInterface $queue;

    protected static $defaultName = 'queue/listen';

    public function __construct(QueueInterface $queue)
    {
        $this->queue = $queue;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Consume messages from the queue')
            ->setHelp('This command runs listening messages from queue.')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the queue');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $queueName = $input->getArgument('name');

        $output->writeln("Listening queue `$queueName`...");

        $this->queue->subscribe(
            $queueName,
            function (bool $handledSuccess, JobInterface $job) use ($output) {
                $result = $handledSuccess ? 'success' : 'failure';
                $className = $job::class;

                $output->writeln("Job `$className` ended in $result");
            }
        );

        return ExitCode::OK;
    }
}
