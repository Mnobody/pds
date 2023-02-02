<?php

declare(strict_types=1);

namespace App\Inspector;

final class CyrillicInspection
{
    private int $count;
    private string $highlighted;

    public function __construct(int $count, string $highlighted)
    {
        $this->count = $count;
        $this->highlighted = $highlighted;
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
