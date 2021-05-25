<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Action;

interface ActiveJob
{
    public function run(array $context = []): void;
}
