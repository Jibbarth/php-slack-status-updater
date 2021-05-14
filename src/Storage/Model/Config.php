<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Storage\Model;

use Barth\SlackUpdater\Exception\MissingConfiguration;

final class Config
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * export data as json_encoded values
     */
    public function export(): string
    {
        return json_encode($this->data);
    }

    public function set(string $key, mixed $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function getSlackToken(): string
    {
        try {
            return $this->retrieveData('slack_token');
        } catch (MissingConfiguration $exception) {
            throw new MissingConfiguration('No slack token configured. Please run auth command before');
        }
    }

    private function retrieveData(string $key): mixed
    {
        if (!array_key_exists($key, $this->data)) {
            throw new MissingConfiguration('No configuration for ' . $key);
        }

        return $this->data[$key];
    }
}
