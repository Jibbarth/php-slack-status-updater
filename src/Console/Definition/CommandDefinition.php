<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Console\Definition;

use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

final class CommandDefinition
{
    public static function get(): InputDefinition
    {
        return new InputDefinition([
            new InputOption('emoji', null, InputOption::VALUE_OPTIONAL, 'Emoji to display'),
            new InputOption('message', null, InputOption::VALUE_OPTIONAL, 'Message to display'),
            new InputOption('type', null, InputOption::VALUE_REQUIRED, '', 'active'),
        ]);
    }
}
