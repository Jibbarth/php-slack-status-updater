<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Storage;

use Barth\SlackUpdater\Console\Application;
use Barth\SlackUpdater\Storage\Model\Config;
use Loilo\StoragePaths\StoragePaths;
use function Symfony\Component\String\u;

final class ConfigStorage
{
    private const CONFIG_FILENAME = 'config.json';

    private string $configPath;
    private string $filePath;

    private ?Config $config = null;

    public function __construct()
    {
        $paths = StoragePaths::for(u(Application::NAME)->snake()->toString());
        $this->configPath = $paths->config();
        $this->filePath = $this->configPath . DIRECTORY_SEPARATOR . self::CONFIG_FILENAME;
    }

    public function getConfig(): Config
    {
        if (null !== $this->config) {
            return $this->config;
        }

        if (! file_exists($this->filePath)) {
            $this->config = new Config([]);
            return $this->config;
        }

        $data = json_decode(file_get_contents($this->filePath), true, 512, JSON_THROW_ON_ERROR);
        $this->config = new Config($data);

        return $this->config;
    }

    public function saveConfig(Config $config): void
    {
        $data = $config->export();
        if (! is_dir($this->configPath) && !mkdir($concurrentDirectory = $this->configPath) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        file_put_contents($this->filePath, $data);
    }
}
