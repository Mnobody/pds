<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('Document\\', '%kernel.project_dir%/src/Document')
        ->exclude(
            [
                '%kernel.project_dir%/src/Document/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/Document/*/config',
            ],
        );

    $configurator->import('services/*.php');
};
