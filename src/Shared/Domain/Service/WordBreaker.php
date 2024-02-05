<?php

declare(strict_types=1);

namespace Shared\Domain\Service;

final class WordBreaker
{
    private const SPLIT_PATTERN = '/\s+/';

    public function break(string $sentence): array
    {
        return preg_split(
            self::SPLIT_PATTERN,
            $sentence,
            -1,
            PREG_SPLIT_NO_EMPTY,
        );
    }
}
