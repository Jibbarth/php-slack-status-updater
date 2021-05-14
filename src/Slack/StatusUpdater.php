<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Slack;

use JoliCode\Slack\Client;
use function Symfony\Component\String\u;

/**
 * Change status (message/emoji) on slack.
 * Required scopes:
 * - users.profile:write
 */
final class StatusUpdater
{
    public function __construct(private Client $client) {
    }

    public function update(string $message, string $emoji, ?\DateTimeInterface $expiration = null): void
    {
        $expirationTs = 0;
        if ($expiration instanceof \DateTimeInterface) {
            $expirationTs = $expiration->getTimestamp();
        }

        $emoji = u($emoji);
        if (!$emoji->isEmpty()) {
            $emoji= $emoji->ensureStart(':')->ensureEnd(':');
        }

        $this->client->usersProfileSet([
            'profile' => json_encode([
                'status_text' => $message,
                'status_emoji' => $emoji->toString(),
                'status_expiration' => $expirationTs,
            ], JSON_THROW_ON_ERROR),
        ]);
    }
}
