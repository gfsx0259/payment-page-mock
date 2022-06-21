<?php

declare(strict_types=1);

namespace App\Command\Queue;

use App\Service\Queue\JobInterface;
use App\Service\Queue\QueueInterface;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Arrays\ArrayHelper;
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
        $that = $this;

        if (!$this->queue->checkConnection()) {
            $this->writeln($output, "Listening queue `$queueName` failed. Broker is not available. Try one more time");

            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->writeln($output, "Listening queue `$queueName`...");

        $this->queue->subscribe(
            $queueName,
            function (bool $handledSuccess, JobInterface $job) use ($that, $output) {
                $result = $handledSuccess ? 'success' : 'failure';
                $className = $job::class;
                $data = $job->serialize();

                $that->writeln($output, "Job `$className` with data `$data` ended in $result");
            }
        );

        return ExitCode::OK;
    }

    private function writeLn(OutputInterface $output, string $text): void
    {
        $date = (new DateTime())->format('Y-m-d H:i:s');

        $output->writeln("[$date] $text");
    }
}
