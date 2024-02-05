<?php

declare(strict_types=1);

namespace CyrillicInspector\Domain\Service;

final class CyrillicInspection
{
    public function __construct(
        private readonly int $count,
        private readonly string $highlighted,
    ) {
    }

    public function count(): int
    {
        return $this->count;
    }

    public function highlighted(): string
    {
        return $this->highlighted;
    }

    public function detected(): bool
    {
        return (bool) $this->count;
    }
}
