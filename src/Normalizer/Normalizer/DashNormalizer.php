<?php

declare(strict_types=1);

namespace App\Normalizer\Normalizer;

final class DashNormalizer implements NormalizerInterface
{
    private const DASH    = '-';
    private const PATTERN = '/\p{Pd}+/u'; // any kind of hyphen or dash

    public function normalize(string $string): string
    {
        return preg_replace(
            self::PATTERN,
            self::DASH,
            $string,
        );
    }
}
