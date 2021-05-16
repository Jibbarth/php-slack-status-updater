<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Barth\SlackUpdater\Action\ActiveJob;
use Barth\SlackUpdater\Action\AwayJob;
use Barth\SlackUpdater\Generator\ScriptGeneratorInterface;
use Barth\SlackUpdater\Slack\Factory\ClientFactory;
use JoliCode\Slack\Client;

return static function (ContainerConfigurator $configurator) {
    // default configuration for services in *this* file
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;
    $services
        ->instanceof(AwayJob::class)->tag('away_job');
    $services
        ->instanceof(ActiveJob::class)->tag('active_job');
    $services
        ->instanceof(ScriptGeneratorInterface::class)->tag('script_generator');

    $services
        ->bind('$awayJobs', tagged_iterator('away_job'))
        ->bind('$activeJobs', tagged_iterator('active_job'))
        ->bind('$scriptGenerators', tagged_iterator('script_generator'))
    ;

    $services->load('Barth\\SlackUpdater\\', '../src/*')
        ->exclude('../src/{Console}');

    $services->load('Barth\\SlackUpdater\\Console\\Command\\', '../src/Console/Command/*')
        ->tag('console.command');

    $services->set(Client::class)
        ->factory([service(ClientFactory::class), 'create']);

};
