<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Presentation\Console\HealthCheckCommand;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->set(HealthCheckCommand::class)
        ->args([
            service('pdt.shared.opentelemetry.tracer'),
            service('pdt.shared.filesystem'),
        ])
        ->tag('console.command', ['command' => 'health-check']);
};
