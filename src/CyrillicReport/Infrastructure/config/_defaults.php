<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('CyrillicReport\\', '%kernel.project_dir%/src/CyrillicReport')
        ->exclude(
            [
                '%kernel.project_dir%/src/CyrillicReport/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/CyrillicReport/*/config',
            ],
        );
};
