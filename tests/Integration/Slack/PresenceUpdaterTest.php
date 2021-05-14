<?php

declare(strict_types=1);

use Barth\SlackUpdater\Slack\PresenceUpdater;
use JoliCode\Slack\ClientFactory;
use Symfony\Component\Dotenv\Dotenv;

beforeEach(function () {
    (new Dotenv())->bootEnv(dirname(__DIR__, 3).'/.env.local');

    $this->slackClient = ClientFactory::create($_ENV['SLACK_TOKEN']);
});

it('mark present', function () {
    $service = new PresenceUpdater($this->slackClient);
    $service->markActive();
    $currentPresence = $this->slackClient->usersGetPresence()->getPresence();

    expect($currentPresence)->toBe('active');
});

it('mark away', function () {
    $service = new PresenceUpdater($this->slackClient);
    $service->markAway();
    $currentPresence = $this->slackClient->usersGetPresence()->getPresence();

    expect($currentPresence)->toBe('away');
});
