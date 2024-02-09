<?php

declare(strict_types=1);

namespace Shared\Presentation\Controller;

use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\SDK\Common\Attribute\Attributes;
use OpenTelemetry\SemConv\TraceAttributes;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class HealthCheckController
{
    public function healthCheck(): Response
    {
        $tracer = Globals::tracerProvider()->getTracer('opentelemetry.instrumentation.php');

        $span = $tracer->spanBuilder('health-check-span-controller')->startSpan();

        $span->setAttribute(TraceAttributes::CODE_NAMESPACE, __NAMESPACE__);
        $span->setAttribute(TraceAttributes::CODE_FILEPATH, __FILE__);
        $span->setAttribute(TraceAttributes::CODE_FUNCTION, __FUNCTION__);

        try {
            $response = new Response(
                '<html><body> OK </body></html>',
            );

            $span->addEvent('response', Attributes::create(['value' => 'OK']));

            return $response;
        } catch (Throwable $e) {
            $span->setStatus(StatusCode::STATUS_ERROR);
            $span->recordException($e, [TraceAttributes::EXCEPTION_ESCAPED => true]);

            throw $e;
        } finally {
            $span->end();
        }
    }
}
