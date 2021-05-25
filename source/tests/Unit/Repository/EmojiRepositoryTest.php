<?php

declare(strict_types=1);

use Barth\SlackUpdater\Repository\EmojiRepository;

beforeEach(function () {
    $this->service = new EmojiRepository();
});

it('can retrieve away emoji list', function () {
    $awayList = $this->service->getAwayEmojis();

    expect($awayList)->toBeIterable();
    expect($awayList)->not()->toBeEmpty();
    expect(count($awayList))->toBeGreaterThan(0);
});

it('can retrieve presence emoji list', function () {
    $awayList = $this->service->getPresenceEmojis();

    expect($awayList)->toBeIterable();
    expect($awayList)->not()->toBeEmpty();
    expect(count($awayList))->toBeGreaterThan(0);
});
