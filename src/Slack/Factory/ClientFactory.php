<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Slack\Factory;

use Barth\SlackUpdater\Storage\ConfigStorage;
use JoliCode\Slack\Client;

final class ClientFactory
{
    public function __construct(private ConfigStorage $configStorage) {
    }

    public function create(): Client
    {
        return \JoliCode\Slack\ClientFactory::create($this->configStorage->getConfig()->getSlackToken());
    }
}
