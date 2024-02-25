<?php

declare(strict_types=1);

namespace Shared\Infrastructure\FileSystem;

interface FileSystemInterface
{
    public function list(): array;

    public function exists(string $path): bool;

    public function read(string $path): string;
}
