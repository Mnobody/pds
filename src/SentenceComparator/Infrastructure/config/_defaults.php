<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('SentenceComparator\\', '%kernel.project_dir%/src/SentenceComparator')
        ->exclude(
            [
                '%kernel.project_dir%/src/SentenceComparator/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/SentenceComparator/*/config',
            ],
        );
};
