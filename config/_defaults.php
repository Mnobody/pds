<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Application\Infrastructure\Module;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->private();

    $services
        ->load('Application\\', '../../src/Application/')
        ->exclude(
            [
                '../../src/Application/Kernel.php',
                '../../src/Application/Domain/{Model,ValueObject}',
            ],
        );

    foreach (Module::cases() as $module) {
        $configurator->import(
            sprintf('../../src/%s/Infrastructure/config/_defaults.php', $module->name),
        );
    }
};
