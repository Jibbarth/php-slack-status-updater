<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Handler;

final class SlackHandler
{
    public function __construct(
        private iterable $awayJobs,
        private iterable $activeJobs,
    ) {
    }

    public function markAway(array $context = []): void
    {
        /** @var \Barth\SlackUpdater\Action\AwayJob $job */
        foreach ($this->awayJobs as $job) {
            $job->run($context);
        }
    }

    public function markActive(array $context = []): void
    {
        /** @var \Barth\SlackUpdater\Action\ActiveJob $job */
        foreach ($this->activeJobs as $job) {
            $job->run($context);
        }
    }
}
