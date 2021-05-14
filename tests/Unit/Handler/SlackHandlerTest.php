<?php

use Barth\SlackUpdater\Action\ActiveJob;
use Barth\SlackUpdater\Handler\SlackHandler;

it('do not throw exception when no jobs available', function() {
    $service = new SlackHandler([], []);

    $service->markAway();
    $service->markActive();
    expect(true)->toBeTrue();
});

it('call Jobs passed in away jobs', function () {
    $job = new class implements \Barth\SlackUpdater\Action\AwayJob {
        public bool $executed = false;
        public function run(array $context = []): void
        {
            $this->executed = true;
        }
    };

    $service = new SlackHandler([$job], []);

    $service->markActive();
    expect($job->executed)->toBeFalse();
    $service->markAway();
    expect($job->executed)->toBeTrue();
});

it('call Jobs passed in present jobs', function () {
    $job = new class implements ActiveJob {
        public bool $executed = false;
        public function run(array $context = []): void
        {
            $this->executed = true;
        }
    };

    $service = new SlackHandler([], [$job]);

    $service->markAway();
    expect($job->executed)->toBeFalse();

    $service->markActive();
    expect($job->executed)->toBeTrue();
});
