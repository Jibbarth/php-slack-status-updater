<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Console\Command;

use Barth\SlackUpdater\Exception\MissingConfiguration;
use Barth\SlackUpdater\Handler\AuthHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class AuthCommand extends Command
{
    protected static $defaultName = 'auth';

    public function __construct(private AuthHandler $authHandler)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->addArgument('slack_token', InputArgument::REQUIRED, 'Slack token to use');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        if (null === $input->getArgument('slack_token')) {
            $token = $io->ask('Please, enter your Slack token to use');
            $input->setArgument('slack_token', $token);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $slackToken = $input->getArgument('slack_token');
        if (!is_string($slackToken)) {
            throw new MissingConfiguration('Invalid slack token');
        }

        $this->authHandler->saveToken($slackToken);

        $output->writeln([
            '',
            '  <bg=green;fg=black;options=bold> Configuration updated. </>',
            '    <fg=blue>•</> Next steps, launch <options=bold>wakeup</> or <options=bold>shutdown</> to see how slack is updated',
            '',
        ]);

        return Command::SUCCESS;
    }
}
