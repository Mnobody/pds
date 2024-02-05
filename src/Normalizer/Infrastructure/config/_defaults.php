<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('Normalizer\\', '%kernel.project_dir%/src/Normalizer')
        ->exclude(
            [
                '%kernel.project_dir%/src/Normalizer/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/Normalizer/*/config',
            ],
        );
};
