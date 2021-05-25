<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Action\Active;

use Barth\SlackUpdater\Action\ActiveJob;
use Barth\SlackUpdater\Slack\PresenceUpdaterInterface;

final class MarkActiveStatusJob implements ActiveJob
{
    public function __construct(private PresenceUpdaterInterface $presenceUpdater) {}

    public function run(array $context = []): void
    {
        $this->presenceUpdater->markActive();
    }
}
