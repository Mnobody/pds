<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('Report\\', '%kernel.project_dir%/src/Report')
        ->exclude(
            [
                '%kernel.project_dir%/src/Report/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/Report/*/config',
            ],
        );
};
