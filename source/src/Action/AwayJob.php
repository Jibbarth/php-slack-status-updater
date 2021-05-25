<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Action;

interface AwayJob
{
    public function run(array $context = []): void;
}
