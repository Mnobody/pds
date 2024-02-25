<?php

declare(strict_types=1);

namespace Document\Presentation\Console;

use Document\Infrastructure\File\FileParserInterface;
use Shared\Infrastructure\FileSystem\FileSystemInterface;
use Shared\Infrastructure\OpenTelemetry\TelemetryTracerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class DocumentListCommand extends Command
{
    public function __construct(
        private readonly TelemetryTracerInterface $tracer,
        private readonly FileSystemInterface $fileSystem,
        private readonly FileParserInterface $parser,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $input->validate();

        $this->tracer->start('document-list-span-command');

        $this->tracer->namespace(__NAMESPACE__);
        $this->tracer->file(__FILE__);
        $this->tracer->function(__FUNCTION__);

        try {
            $list = $this->fileSystem->list();

            $output->writeln('<comment>-----------------------------------------</comment>');

            foreach ($list as $path) {
                $output->writeln('<question>File:</question> ' . $path);
                $this->tracer->event('writeln', ['path' => $path]);

                $output->writeln('<question>Parsed:</question>');
                $output->writeln($this->parser->parse($path));
                $this->tracer->event('document-content-outputted', ['path' => $path]);
                $output->writeln('<comment>-----------------------------------------</comment>');
            }

            $output->writeln('<info>OK</info>');

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
