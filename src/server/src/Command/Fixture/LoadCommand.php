<?php

declare(strict_types=1);

namespace App\Command\Fixture;

use App\Service\DataLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;
use Yiisoft\Yii\Console\ExitCode;


final class LoadCommand extends Command
{
    protected static $defaultName = 'fixture/load';

    private DataLoader $dataLoader;

    public function __construct(DataLoader $dataLoader)
    {
        $this->dataLoader = $dataLoader;
        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setDescription('Load fixtures')
            ->setHelp('This command load necessary fixed data');
    }

    /**
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->dataLoader->load();

        return ExitCode::OK;
    }
}
