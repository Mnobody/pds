<?php

declare(strict_types=1);

namespace Document\Infrastructure\File;

interface FileParserInterface
{
    public function parse(string $path): string;
}
