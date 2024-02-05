<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('EnglishLanguageChecker\\', '%kernel.project_dir%/src/EnglishLanguageChecker')
        ->exclude(
            [
                '%kernel.project_dir%/src/EnglishLanguageChecker/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/EnglishLanguageChecker/*/config',
            ],
        );
};
