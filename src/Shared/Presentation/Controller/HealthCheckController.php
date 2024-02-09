<?php

declare(strict_types=1);

namespace Shared\Presentation\Controller;

use Shared\Infrastructure\OpenTelemetry\TelemetryTracer;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class HealthCheckController
{
    public function __construct(private readonly TelemetryTracer $tracer)
    {
    }

    public function healthCheck(): Response
    {
        $this->tracer->start('healh-check-span-controller');

        $this->tracer->namespace(__NAMESPACE__);
        $this->tracer->file(__FILE__);
        $this->tracer->function(__FUNCTION__);

        try {
            $response = new Response(
                '<html><body> OK </body></html>',
            );

            $this->tracer->event('response', ['value' => 'OK']);

            return $response;
        } catch (Throwable $e) {
            $this->tracer->exception($e);

            throw $e;
        } finally {
            $this->tracer->finish();
        }
    }
}
