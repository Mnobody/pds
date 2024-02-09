<?php

declare(strict_types=1);

use Shared\Presentation\Controller\HealthCheckController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes
        ->add('health-check', '/health-check')
        ->controller([HealthCheckController::class, 'healthCheck'])
        ->methods(['GET']);
};
