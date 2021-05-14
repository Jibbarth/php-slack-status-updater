<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Application;

use Symfony\Component\Console\Application;

final class Main extends Application
{
    private const VERSION = '1.0.0';

    public function __construct()
    {
        parent::__construct('Slack Status Updater', self::VERSION);
    }
}
