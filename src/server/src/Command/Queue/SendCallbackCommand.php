<?php

declare(strict_types=1);

namespace App\Command\Queue;

use App\Middleware\ConsoleOutputFormatter;
use App\Service\Queue\QueueException;
use App\Service\Queue\QueueInterface;
use App\Stub\Job\SendCallbackJob;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Yii\Console\ExitCode;

final class SendCallbackCommand extends Command
{
    protected static $defaultName = 'queue/sendCallback';

    public function __construct(
        private QueueInterface $queue
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Send callback to consumer')
            ->addArgument('request_id', InputArgument::REQUIRED, 'Request id');
    }

    /**
     * @throws QueueException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->setFormatter(new ConsoleOutputFormatter());

        if (!$this->queue->checkConnection()) {
            $output->writeln('Send callback failed. Broker is not available. Try one more time');

            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->queue->push(SendCallbackJob::class, ['requestId' => $input->getArgument('request_id')]);

        return ExitCode::OK;
    }
}
