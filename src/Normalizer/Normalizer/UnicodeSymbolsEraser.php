<?php

declare(strict_types=1);

namespace App\Normalizer\Normalizer;

final class UnicodeSymbolsEraser implements NormalizerInterface
{
    private const EMPTY = '';
    private const PATTERN = '/[\x00-\x09\x0B-\x1F]/u';

    public function normalize(string $string): string
    {
        return preg_replace(
            self::PATTERN,
            self::EMPTY,
            $string
        );
    }
}
