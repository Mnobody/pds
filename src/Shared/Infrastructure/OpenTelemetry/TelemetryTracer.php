<?php

declare(strict_types=1);

namespace Shared\Infrastructure\OpenTelemetry;

use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\SDK\Common\Attribute\Attributes;
use OpenTelemetry\SemConv\TraceAttributes;
use Throwable;

final class TelemetryTracer
{
    private const TRACER_NAME = 'opentelemetry.instrumentation.php';

    private ?SpanInterface $span = null;

    public function start(string $name): void
    {
        $tracer = Globals::tracerProvider()->getTracer(self::TRACER_NAME);

        $this->span = $tracer->spanBuilder($name)->startSpan();
    }

    public function finish(): void
    {
        $this->span?->end();
    }

    public function exception(Throwable $e): void
    {
        $this->span?->setStatus(StatusCode::STATUS_ERROR);
        $this->span?->recordException($e, [TraceAttributes::EXCEPTION_ESCAPED => true]);
    }

    public function attribute(string $name, mixed $value): void
    {
        $this->span?->setAttribute($name, $value);
    }

    public function event(string $name, array $attributes): void
    {
        $this->span?->addEvent(
            $name,
            Attributes::create($attributes),
        );
    }

    public function namespace(string $namespace): void
    {
        $this->span?->setAttribute(TraceAttributes::CODE_NAMESPACE, $namespace);
    }

    public function file(string $file): void
    {
        $this->span?->setAttribute(TraceAttributes::CODE_FILEPATH, $file);
    }

    public function function(string $function): void
    {
        $this->span?->setAttribute(TraceAttributes::CODE_FUNCTION, $function);
    }

    public function try(string $name, callable $callable, ...$params): mixed
    {
        $this->start($name);

        try {
            return $callable(...$params);
        } catch (Throwable $e) {
            $this->exception($e);

            throw $e;
        } finally {
            $this->finish();
        }
    }
}
