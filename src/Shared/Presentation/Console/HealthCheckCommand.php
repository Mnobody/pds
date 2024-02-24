<?php

declare(strict_types=1);

namespace Shared\Presentation\Console;

use Shared\Infrastructure\FileSystem\FileSystemInterface;
use Shared\Infrastructure\OpenTelemetry\TelemetryTracerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class HealthCheckCommand extends Command
{
    public function __construct(
        private readonly TelemetryTracerInterface $tracer,
        private readonly FileSystemInterface $fileSystem,
    ) {
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
            $list = $this->fileSystem->list();

            foreach ($list as $path) {
                $output->writeln($path);
                $this->tracer->event('writeln', ['path' => $path]);
            }

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
