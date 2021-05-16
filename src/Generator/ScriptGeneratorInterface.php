<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Generator;

interface ScriptGeneratorInterface
{
    public function generate(string $commandName, array $options): string;

    public function support(string $commandName, array $options): bool;
}
