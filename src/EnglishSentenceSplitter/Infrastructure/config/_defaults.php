<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->services()
        ->load('EnglishSentenceSplitter\\', '%kernel.project_dir%/src/EnglishSentenceSplitter')
        ->exclude(
            [
                '%kernel.project_dir%/src/EnglishSentenceSplitter/Domain/{Model,ValueObject}',
                '%kernel.project_dir%/src/EnglishSentenceSplitter/*/config',
            ],
        );
};
