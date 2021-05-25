<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Generator\Script;

use Barth\SlackUpdater\Exception\NotImplementedYet;
use Barth\SlackUpdater\Generator\ScriptGeneratorInterface;

final class DarwinScriptGenerator implements ScriptGeneratorInterface
{
    public function generate(string $commandName, array $options): string
    {
        throw new NotImplementedYet('Script generator for MacOs is not implemented yet');
    }

    public function support(string $commandName, array $options): bool
    {
        return PHP_OS_FAMILY === 'Darwin';
    }
}
