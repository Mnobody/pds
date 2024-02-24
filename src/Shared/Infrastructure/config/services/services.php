<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Infrastructure\FileSystem\FileSystem;
use Shared\Infrastructure\FileSystem\FileSystemInterface;
use Shared\Infrastructure\Message\TestMessage;
use Shared\Infrastructure\MessageHandler\TestMessageHandler;
use Shared\Infrastructure\OpenTelemetry\TelemetryTracer;
use Shared\Infrastructure\OpenTelemetry\TelemetryTracerInterface;
use Shared\Presentation\Controller\HealthCheckController;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->set('pdt.shared.opentelemetry.tracer', TelemetryTracer::class);

    $services
        ->alias(TelemetryTracerInterface::class, 'pdt.shared.opentelemetry.tracer');

    $services
        ->set(HealthCheckController::class)
        ->args([
            service('pdt.shared.opentelemetry.tracer'),
            service('messenger.bus.default'),
        ])
        ->tag('controller.service_arguments');

    $services
        ->set('pdt.shared.filesystem', FileSystem::class);

    $services
        ->alias(FileSystemInterface::class, 'pdt.shared.filesystem');

    $services->set(TestMessageHandler::class)
        ->args([])
        ->tag('messenger.message_handler', ['handles' => TestMessage::class]);
};
