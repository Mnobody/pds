<?php

declare(strict_types=1);

namespace Report\Domain\Service;

final class SimilarityFormatter
{
    private const PRECISION  = 2;
    private const MULTIPLIER = 100;

    public function percentage(float $similarity): int
    {
        // convert to string to avoid floating point precision issues
        return (int) (string) (self::MULTIPLIER * round($similarity, self::PRECISION, PHP_ROUND_HALF_UP));
    }
}
