<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Slack;

interface StatusUpdaterInterface
{
    public function update(string $message, string $emoji): void;
}
