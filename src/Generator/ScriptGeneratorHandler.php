<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Generator;

final class ScriptGeneratorHandler
{
    public function __construct(private iterable $scriptGenerators) {
    }

    public function generate(string $command, array $options = []): array
    {
        $filenames = [];
        /** @var \Barth\SlackUpdater\Generator\ScriptGeneratorInterface $scriptGenerator */
        foreach ($this->scriptGenerators as $scriptGenerator) {
            if ($scriptGenerator->support($command, $options)) {
                $filenames[] = $scriptGenerator->generate($command, $options);
            }
        }

        return $filenames;
    }
}
