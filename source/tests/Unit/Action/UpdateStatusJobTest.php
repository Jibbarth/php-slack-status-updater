<?php

declare(strict_types=1);

use Barth\SlackUpdater\Action\UpdateStatusJob;
use Barth\SlackUpdater\Slack\StatusUpdaterInterface;

beforeEach(function () {
    $this->updater = new class implements StatusUpdaterInterface {
        public array $data = [];
        public function update(string $message, string $emoji): void
        {
            $this->data = [
                'message' => $message,
                'emoji' => $emoji,
            ];
        }
    };

    $this->service = new UpdateStatusJob($this->updater);
});

it('can be run without context', function () {
    $initialData = $this->updater->data;
    $this->service->run();

    expect($this->updater->data)->not()->toBe($initialData);
    expect($this->updater->data)->toHaveKeys(['message', 'emoji']);
});

it('take context', function () {
    $initialData = $this->updater->data;
    $this->service->run(['custom_message' => 'hello', 'custom_emoji' => ':zzz:']);

    expect($this->updater->data)->not()->toBe($initialData);
    expect($this->updater->data)->toHaveKeys(['message', 'emoji']);
});
