<?php

declare(strict_types=1);

use Barth\SlackUpdater\Generator\Script\WindowsScriptGenerator;

it('support generation when OS is Windows', function () {
    $generator = new WindowsScriptGenerator();
    expect($generator->support('test', []))->toBeTrue();
})
    ->skip(PHP_OS_FAMILY !== 'Windows');

it('does not support generation when OS is different of Windows', function () {
    $generator = new WindowsScriptGenerator();
    expect($generator->support('test', []))->toBeFalse();
})
    ->skip(PHP_OS_FAMILY === 'Windows');

it('throw an Not Implemented yet exception', function () {
    $generator = new WindowsScriptGenerator();
    $generator->generate('test', []);
})->throws(\Barth\SlackUpdater\Exception\NotImplementedYet::class);
