<?php
declare(strict_types=1);

namespace Barth\SlackUpdater\Action;

use Barth\SlackUpdater\Slack\StatusUpdaterInterface;

final class UpdateStatusJob implements AwayJob, ActiveJob
{
    public function __construct(private StatusUpdaterInterface $statusUpdater) {}

    public function run(array $context = []): void
    {
        $message = $emoji = '';
        if (array_key_exists('custom_message', $context)) {
            $message = $context['custom_message'];
        }

        if (array_key_exists('custom_emoji', $context)) {
            $emoji = $context['custom_emoji'];
        }

        $this->statusUpdater->update($message, $emoji);
    }
}
