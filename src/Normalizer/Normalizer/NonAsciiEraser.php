<?php

declare(strict_types=1);

namespace App\Normalizer\Normalizer;

final class NonAsciiEraser implements NormalizerInterface
{
    private const EMPTY = '';
    private const PATTERN = '/[^[:ascii:]]/';

    public function normalize(string $string): string
    {
        return preg_replace(
            self::PATTERN,
            self::EMPTY,
            $string
        );
    }
}
