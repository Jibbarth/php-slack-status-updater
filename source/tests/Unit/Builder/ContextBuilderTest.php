<?php

use Barth\SlackUpdater\Builder\ContextBuilder;
use Barth\SlackUpdater\Console\Definition\CommandDefinition;
use Barth\SlackUpdater\Repository\EmojiRepository;
use Symfony\Component\Console\Input\ArrayInput;

beforeEach(function () {
    $this->service = new ContextBuilder(new EmojiRepository());
});

it('fetch a random away emoji when no emoji option', function () {
    $input = new ArrayInput(['--type'=> 'away'], CommandDefinition::get());

    $context = $this->service->build($input);
    expect($context)->toHaveKey('custom_emoji');
    expect((new EmojiRepository())->getAwayEmojis())->toContain($context['custom_emoji']);
});

it('fetch a random present emoji when no emoji option', function () {
    $input = new ArrayInput(['--type'=> 'active'], CommandDefinition::get());

    $context = $this->service->build($input);
    expect($context)->toHaveKey('custom_emoji');
    expect((new EmojiRepository())->getPresenceEmojis())->toContain($context['custom_emoji']);
});

it('use option emoji when there is an option with it', function () {
    $input = new ArrayInput(['--emoji'=> 'zzz'], CommandDefinition::get());

    $context = $this->service->build($input);
    expect($context)->toHaveKey('custom_emoji');
    expect($context['custom_emoji'])->toBe('zzz');
});

it('has no custom message in context', function () {
    $input = new ArrayInput(['--type'=> 'away'], CommandDefinition::get());

    $context = $this->service->build($input);
    expect($context)->not()->toHaveKey('custom_message');
});

it('has custom message in context', function () {
    $input = new ArrayInput(['--message'=> 'I\'m done.'], CommandDefinition::get());

    $context = $this->service->build($input);
    expect($context)->toHaveKey('custom_message');
    expect($context['custom_message'])->toBe('I\'m done.');
});
