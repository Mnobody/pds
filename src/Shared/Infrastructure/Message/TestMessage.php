<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Message;

final class TestMessage
{
    public function __construct(private int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
