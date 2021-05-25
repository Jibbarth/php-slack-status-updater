<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Console;

use Barth\SlackUpdater\Handler\SlackHandler;
use Symfony\Component\Console\Application as BaseApp;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class Application extends BaseApp
{
    public const NAME = 'Slack Status Updater';
    private const VERSION = '1.0.0';

    public function __construct(private ContainerBuilder $containerBuilder)
    {
        parent::__construct(self::NAME, self::VERSION);
    }

    /**
     * Runs the current application.
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->containerBuilder->compile();
        $this->setCommandLoader($this->containerBuilder->get('console.command_loader'));

        return parent::doRun($input, $output);
    }
}
