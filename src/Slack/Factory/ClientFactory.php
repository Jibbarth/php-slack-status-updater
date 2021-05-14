<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Slack\Factory;

use JoliCode\Slack\Client;

final class ClientFactory
{
    public function __construct()
    {
        $this->token = 'xoxp-xxxx';
    }

    public function create(): Client
    {
        return \JoliCode\Slack\ClientFactory::create($this->token);
    }
}
