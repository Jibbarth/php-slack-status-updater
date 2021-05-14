<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Slack;

use JoliCode\Slack\Client;

/**
 * Mark presence or not on slack.
 * Required scopes:
 * - users:write
 */
final class PresenceUpdater implements PresenceUpdaterInterface
{
    public function __construct(private Client $client) {
    }

    public function markActive(): void
    {
        $this->client->usersSetPresence(['presence' => 'auto']);
    }

    public function markAway(): void
    {
        $this->client->usersSetPresence(['presence' => 'away']);
    }
}
