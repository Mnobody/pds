<?php

declare(strict_types=1);

namespace Shared\Presentation\Controller;

use Shared\Infrastructure\Message\TestMessage;
use Shared\Infrastructure\OpenTelemetry\TelemetryTracer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class HealthCheckController
{
    public function __construct(private readonly TelemetryTracer $tracer, private readonly MessageBusInterface $bus)
    {
    }

    public function healthCheck(): Response
    {
        $this->tracer->start('health-check-span-controller');

        $this->tracer->namespace(__NAMESPACE__);
        $this->tracer->file(__FILE__);
        $this->tracer->function(__FUNCTION__);

        try {
            $this->bus->dispatch(new TestMessage(13));

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
