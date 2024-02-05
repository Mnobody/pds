<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('Orchestrator\\', '%kernel.project_dir%/src/Orchestrator')
        ->exclude(
            [
                '%kernel.project_dir%/src/Orchestrator/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/Orchestrator/*/config',
            ],
        );
};
