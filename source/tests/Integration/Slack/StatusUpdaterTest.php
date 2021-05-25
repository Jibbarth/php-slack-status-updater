<?php

declare(strict_types=1);

use Barth\SlackUpdater\Slack\StatusUpdater;
use JoliCode\Slack\ClientFactory;
use Symfony\Component\Dotenv\Dotenv;

beforeEach(function () {
    (new Dotenv())->bootEnv(dirname(__DIR__, 3).'/.env.local');

    $this->slackClient = ClientFactory::create($_ENV['SLACK_TOKEN']);
});

it('update slack status', function () {
    $service = new StatusUpdater($this->slackClient);
    $service->update('test', ':thumbsup:');

    $profile = $this->slackClient->usersProfileGet()->getProfile();

    expect($profile->getStatusText())->toBe('test');
    expect($profile->getStatusEmoji())->toBe(':thumbsup:');
    expect($profile->getStatusExpiration())->toBe(0);
});

it('ensure emoji is correctly delimited and can specify expiration', function () {
    $service = new StatusUpdater($this->slackClient);
    $expiration = (new DateTime())->modify('+1 minute');
    $service->update('Disappear in one minute', 'hourglass', $expiration);

    $profile = $this->slackClient->usersProfileGet()->getProfile();

    expect($profile->getStatusEmoji())->toBe(':hourglass:');
    expect($profile->getStatusExpiration())->toBe($expiration->getTimestamp());
});


it('can pass an empty values', function (){
    $service = new StatusUpdater($this->slackClient);
    $service->update('', '');

    $profile = $this->slackClient->usersProfileGet()->getProfile();
    // slack set default emoji to :speech_balloon:
    expect($profile->getStatusEmoji())->toBeEmpty();
    expect($profile->getStatusText())->toBeEmpty();
});
