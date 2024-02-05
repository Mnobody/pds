<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('EnglishStemmer\\', '%kernel.project_dir%/src/EnglishStemmer')
        ->exclude(
            [
                '%kernel.project_dir%/src/EnglishStemmer/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/EnglishStemmer/*/config',
            ],
        );
};
