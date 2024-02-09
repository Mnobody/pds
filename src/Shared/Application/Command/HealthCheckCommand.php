<?php

declare(strict_types=1);

namespace Shared\Application\Command;

use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\SDK\Common\Attribute\Attributes;
use OpenTelemetry\SemConv\TraceAttributes;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class HealthCheckCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $input->validate();

        $tracer = Globals::tracerProvider()->getTracer('opentelemetry.instrumentation.php');

        $span = $tracer->spanBuilder('health-check-span-command')->startSpan();

        $span->setAttribute(TraceAttributes::CODE_NAMESPACE, __NAMESPACE__);
        $span->setAttribute(TraceAttributes::CODE_FILEPATH, __FILE__);
        $span->setAttribute(TraceAttributes::CODE_FUNCTION, __FUNCTION__);

        try {
            $output->writeln('OK');

            $span->addEvent('writeln', Attributes::create(['value' => 'OK']));
        } catch (Throwable $e) {
            $span->setStatus(StatusCode::STATUS_ERROR);
            $span->recordException($e, [TraceAttributes::EXCEPTION_ESCAPED => true]);
        } finally {
            $span->end();
        }

        return Command::SUCCESS;
    }
}
