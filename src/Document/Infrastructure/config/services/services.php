<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Document\Infrastructure\File\FileParser;
use Document\Infrastructure\File\FileParserInterface;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->set('pdt.document.file.parser', FileParser::class)
        ->args([
            service('pdt.shared.filesystem'),
        ]);

    $services
        ->alias(FileParserInterface::class, 'pdt.document.file.parser');
};
