<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Console\Command;

use Barth\SlackUpdater\Console\Definition\CommandDefinition;
use Barth\SlackUpdater\Exception\NotImplementedYet;
use Barth\SlackUpdater\Generator\ScriptGeneratorHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GenerateScriptCommand extends Command
{
    protected static $defaultName = 'generate-script';


    public function __construct(
        private ScriptGeneratorHandler $scriptGenerator,
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $definition = CommandDefinition::get();
        $definition->addArgument(new InputArgument('command-name', InputArgument::REQUIRED, 'The script to generate (wakeup/shutdown)'));
        $this->setDefinition($definition);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        if (null === $input->getArgument('command-name')) {
            $choices = ['wakeup', 'shutdown'];
            $question = new Question('What type of script to generate ? (wakeup or shutdown)');
            $question->setAutocompleterValues($choices);
            $question->setMaxAttempts(3);
            $question->setValidator(static function ($answer) use ($choices): string{
                if (!is_string($answer) || !in_array($answer, $choices)) {
                    throw new \RuntimeException(
                        'Invalid Command Name'
                    );
                }

                return $answer;
            });
            $command = $io->askQuestion($question);

            $input->setArgument('command-name', $command);
        }

        if (null === $input->getOption('emoji')) {
            $emoji = $io->ask('What emoji should be used ? (press enter to keep random choice)');
            $input->setOption('emoji', $emoji);
        }


        if (null === $input->getOption('message')) {
            $emoji = $io->ask('What message should be attached to status ? (press enter to keep empty)');
            $input->setOption('message', $emoji);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commandName = $input->getArgument('command-name');
        $options = [];

        if (null !== $input->getOption('emoji')) {
            $options['custom_emoji'] = $input->getOption('emoji');
        }

        if (null !== $input->getOption('message')) {
            $options['custom_message'] = $input->getOption('message');
        }

        try {
            $filenames = $this->scriptGenerator->generate($commandName, $options);
        } catch (NotImplementedYet $exception) {
            $output->writeln([
                '',
                '  <bg=red;fg=white;options=bold> Not implemented yet </>',
                '',
                '    <fg=red>•</> ' . $exception->getMessage(),
                '',
                '    <fg=blue>•</> Want to help ? Send a <href=https://github.com/Jibbarth/php-slack-status-updater>pull request</>',
                '',
            ]);

            return Command::FAILURE;
        }

        $output->writeln([
            '',
            '  <bg=green;fg=black;options=bold> End of process </>',
            '',
        ]);
        array_walk($filenames, static function (string $filename) use ($output): void {
            if (!file_exists($filename)) {
                $output->writeln([
                    '',
                    '  <bg=red;options=bold> Error while creating script. </>',
                    '    <fg=red>•</> Check if you have rights to write on ' . $filename,
                    '',
                ]);
                return;
            }
            $output->writeln([
                '    <fg=blue>•</> ' . $filename,
            ]);
        });

        $output->writeln('');

        return Command::SUCCESS;
    }
}
