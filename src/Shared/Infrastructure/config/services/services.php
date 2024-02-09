<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Infrastructure\OpenTelemetry\TelemetryTracer;
use Shared\Presentation\Controller\HealthCheckController;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->set('pdt.opentelemetry.tracer', TelemetryTracer::class);

    $services
        ->set(HealthCheckController::class)
        ->args([
            service('pdt.opentelemetry.tracer'),
        ])
        ->tag('controller.service_arguments');
};
