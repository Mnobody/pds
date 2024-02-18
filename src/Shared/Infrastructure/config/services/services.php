<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Infrastructure\Message\TestMessage;
use Shared\Infrastructure\MessageHandler\TestMessageHandler;
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
            service('messenger.bus.default'),
        ])
        ->tag('controller.service_arguments');

    $services->set(TestMessageHandler::class)
        ->args([])
        ->tag('messenger.message_handler', ['handles' => TestMessage::class]);
};
