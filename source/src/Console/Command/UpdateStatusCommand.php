<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Console\Command;

use Barth\SlackUpdater\Action\UpdateStatusJob;
use Barth\SlackUpdater\Builder\ContextBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class UpdateStatusCommand extends Command
{
    protected static $defaultName = 'update-status';

    public function __construct(
        private ContextBuilder $contextBuilder,
        private UpdateStatusJob $updateStatusJob
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->addOption('emoji', null, InputOption::VALUE_REQUIRED, 'Emoji to display')
            ->addOption('message', null, InputOption::VALUE_OPTIONAL, 'Message to display');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $context = $this->contextBuilder->build($input);
        $this->updateStatusJob->run($context);

        return Command::SUCCESS;
    }
}
