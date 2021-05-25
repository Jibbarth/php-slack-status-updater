<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Provider;

final class BinaryPathProvider
{
    public function get(): string
    {
        $pharPath = \Phar::running(false);
        if ($pharPath !== '') {
            return $pharPath;
        }

        $rootDir = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'bin';
        $binary = 'slack-status-updater';

        return $rootDir . DIRECTORY_SEPARATOR . $binary;
    }
}
