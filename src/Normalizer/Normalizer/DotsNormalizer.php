<?php

declare(strict_types=1);

namespace App\Normalizer\Normalizer;

final class DotsNormalizer implements NormalizerInterface
{
    private const DOTS    = '...';
    private const PATTERN = '/…/u';

    public function normalize(string $string): string
    {
        return preg_replace(
            self::PATTERN,
            self::DOTS,
            $string,
        );
    }
}
