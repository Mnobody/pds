<?php

declare(strict_types=1);

namespace Normalizer\Domain\Service\Normalizer;

final class NonAsciiEraser implements NormalizerInterface
{
    private const EMPTY   = '';
    private const PATTERN = '/[^[:ascii:]]/';

    public function normalize(string $string): string
    {
        return preg_replace(
            self::PATTERN,
            self::EMPTY,
            $string,
        );
    }
}
