<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('Shared\\', '%kernel.project_dir%/src/Shared')
        ->exclude(
            [
                '%kernel.project_dir%/src/Shared/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/Shared/*/config',
            ],
        );
};
