<?php

declare(strict_types=1);

namespace Shared\Presentation\Console;

use Shared\Infrastructure\OpenTelemetry\TelemetryTracer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class HealthCheckCommand extends Command
{
    public function __construct(private readonly TelemetryTracer $tracer)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $input->validate();

        $this->tracer->start('health-check-span-command');

        $this->tracer->namespace(__NAMESPACE__);
        $this->tracer->file(__FILE__);
        $this->tracer->function(__FUNCTION__);

        try {
            $output->writeln('OK');

            $this->tracer->event('writeln', ['value' => 'OK']);

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->tracer->exception($e);

            throw $e;
        } finally {
            $this->tracer->finish();
        }
    }
}
