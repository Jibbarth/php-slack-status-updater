<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Command;

use Barth\SlackUpdater\Builder\ContextBuilder;
use Barth\SlackUpdater\Command\Definition\CommandDefinition;
use Barth\SlackUpdater\Handler\SlackHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class WakeUpCommand extends Command
{
    protected static $defaultName = 'wakeup';

    public function __construct(
        private ContextBuilder $contextBuilder,
        private SlackHandler $slackHandler,
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->setDefinition(CommandDefinition::get());
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $input->setOption('type', 'active');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $context = $this->contextBuilder->build($input);
        $this->slackHandler->markActive($context);

        return Command::SUCCESS;
    }
}
