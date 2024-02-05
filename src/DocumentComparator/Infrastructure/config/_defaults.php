<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('DocumentComparator\\', '%kernel.project_dir%/src/DocumentComparator')
        ->exclude(
            [
                '%kernel.project_dir%/src/DocumentComparator/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/DocumentComparator/*/config',
            ],
        );
};
