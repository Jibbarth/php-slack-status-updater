<?php

use Barth\SlackUpdater\Storage\ConfigStorage;

beforeEach(function () {
    $this->service = new ConfigStorage();
});

it('return a Config instance', function () {
    $config = $this->service->getConfig();

    expect($config)->toBeInstanceOf(\Barth\SlackUpdater\Storage\Model\Config::class);
});


it('keep the same config instance after modifying it', function () {
    $config = $this->service->getConfig();

    $config->set('hello', 'hi');

    $newConfig = $this->service->getConfig();

    expect($newConfig)->toBe($config);
});

it('it is able to store file and reload the config', function () {
    $config = new \Barth\SlackUpdater\Storage\Model\Config(['hello' => 'hi']);

    $this->service->saveConfig($config);

    $configStorage = new ConfigStorage();
    $finalConfig = $configStorage->getConfig();

    expect($finalConfig->export())->toBe($config->export());
});
