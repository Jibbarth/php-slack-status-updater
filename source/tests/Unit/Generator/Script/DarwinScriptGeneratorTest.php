<?php

declare(strict_types=1);

use Barth\SlackUpdater\Generator\Script\DarwinScriptGenerator;

it('support generation when OS is MacOs', function () {
    $generator = new DarwinScriptGenerator();
    expect($generator->support('test', []))->toBeTrue();
})
    ->skip(PHP_OS_FAMILY !== 'Darwin');

it('does not support generation when OS is different of MacOs', function () {
    $generator = new DarwinScriptGenerator();
    expect($generator->support('test', []))->toBeFalse();
})
    ->skip(PHP_OS_FAMILY === 'Darwin');

it('throw an Not Implemented yet exception', function () {
    $generator = new DarwinScriptGenerator();
    $generator->generate('test', []);
})->throws(\Barth\SlackUpdater\Exception\NotImplementedYet::class);
