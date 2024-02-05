<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('CyrillicInspector\\', '%kernel.project_dir%/src/CyrillicInspector')
        ->exclude(
            [
                '%kernel.project_dir%/src/CyrillicInspector/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/CyrillicInspector/*/config',
            ],
        );
};
