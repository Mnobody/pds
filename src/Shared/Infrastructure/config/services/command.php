<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Command\HealthCheckCommand;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->set(HealthCheckCommand::class)
        ->tag('console.command', ['command' => 'health-check']);
};
