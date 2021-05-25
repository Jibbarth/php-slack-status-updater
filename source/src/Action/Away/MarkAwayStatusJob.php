<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Action\Away;

use Barth\SlackUpdater\Action\AwayJob;
use Barth\SlackUpdater\Slack\PresenceUpdaterInterface;

final class MarkAwayStatusJob implements AwayJob
{
    public function __construct(private PresenceUpdaterInterface $presenceUpdater) {}

    public function run(array $context = []): void
    {
        $this->presenceUpdater->markAway();
    }
}
