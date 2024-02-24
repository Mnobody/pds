<?php

declare(strict_types=1);

namespace Shared\Infrastructure\FileSystem;

interface FileSystemInterface
{
    public function list(): array;
}
