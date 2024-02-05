<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('CyrillicNormalizer\\', '%kernel.project_dir%/src/CyrillicNormalizer')
        ->exclude(
            [
                '%kernel.project_dir%/src/CyrillicNormalizer/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/CyrillicNormalizer/*/config',
            ],
        );
};
