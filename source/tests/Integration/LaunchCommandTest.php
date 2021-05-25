<?php

it('display help', function () {
    $process = new Symfony\Component\Process\Process(['bin/slack-status-updater', '-h']);
    $process->run();

    expect($process->getExitCode())->toBe(0);
    expect($process->getOutput())->not()->toBeNull();
    expect($process->getErrorOutput())->toBeEmpty();
});
