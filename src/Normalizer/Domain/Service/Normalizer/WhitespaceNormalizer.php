<?php

declare(strict_types=1);

namespace Normalizer\Domain\Service\Normalizer;

final class WhitespaceNormalizer implements NormalizerInterface
{
    private const SPACE   = ' ';
    private const PATTERN = '/[ \r\t\f]+/';

    public function normalize(string $string): string
    {
        return preg_replace(
            self::PATTERN,
            self::SPACE,
            $string,
        );
    }
}
