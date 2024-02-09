<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Application\Infrastructure\Module;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $configurator): void {

    foreach (Module::cases() as $module) {
        $configurator->import(
            sprintf(
                '../../src/%s/Infrastructure/config/{_routes.php}',
                $module->name,
            ),
        );
    }
};
