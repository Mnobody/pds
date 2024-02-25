<?php

declare(strict_types=1);

namespace Document\Infrastructure\File;

use Shared\Infrastructure\FileSystem\FileSystemInterface;
use Throwable;

final class FileParser implements FileParserInterface
{
    public function __construct(private readonly FileSystemInterface $system)
    {
    }

    public function parse(string $path): string
    {
        if (false === $this->system->exists($path)) {
            throw new ParserException('File does not exist');
        }

        try {
            $temp = tempnam(sys_get_temp_dir(), uniqid());

            file_put_contents(
                $temp,
                $this->system->read($path),
            );

            $parsed = shell_exec(
                sprintf('pdftotext %s - 2>&1', $temp),
            );

            if (false === is_string($parsed)) {
                throw new ParserException('Conversion failed');
            }

            return $parsed;
        } catch (Throwable $e) {
            throw new ParserException(previous: $e);
        } finally {
            unlink($temp);
        }
    }
}
