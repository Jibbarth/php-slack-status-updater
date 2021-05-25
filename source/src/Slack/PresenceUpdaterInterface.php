<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Slack;

interface PresenceUpdaterInterface
{
    public function markActive(): void;

    public function markAway(): void;
}
