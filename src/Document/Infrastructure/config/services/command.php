<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Document\Presentation\Console\DocumentListCommand;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->set(DocumentListCommand::class)
        ->args([
            service('pdt.shared.opentelemetry.tracer'),
            service('pdt.shared.filesystem'),
            service('pdt.document.file.parser'),
        ])
        ->tag('console.command', ['command' => 'document-list']);
};
