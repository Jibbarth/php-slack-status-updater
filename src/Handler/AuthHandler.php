<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Handler;


use Barth\SlackUpdater\Storage\ConfigStorage;

final class AuthHandler
{
    public function __construct(private ConfigStorage $configStorage)
    {}

    public function saveToken(string $token): void
    {
        $config = $this->configStorage->getConfig();
        $config->set('slack_token', $token);

        $this->configStorage->saveConfig($config);
    }
}
