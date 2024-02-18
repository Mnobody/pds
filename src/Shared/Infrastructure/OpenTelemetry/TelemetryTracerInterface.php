<?php

declare(strict_types=1);

namespace Shared\Infrastructure\OpenTelemetry;

use Throwable;

interface TelemetryTracerInterface
{
    public function start(string $name): void;

    public function finish(): void;

    public function exception(Throwable $e): void;

    public function attribute(string $name, mixed $value): void;

    public function event(string $name, array $attributes): void;

    public function namespace(string $namespace): void;

    public function file(string $file): void;

    public function function(string $function): void;

    public function try(string $name, callable $callable, ...$params): mixed;
}
