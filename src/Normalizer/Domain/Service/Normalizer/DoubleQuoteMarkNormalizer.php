<?php

declare(strict_types=1);

namespace Normalizer\Domain\Service\Normalizer;

final class DoubleQuoteMarkNormalizer implements NormalizerInterface
{
    private const MARK    = '"';
    private const PATTERN = '/([«»“”„‟]|\'\'|``)/u';

    public function normalize(string $string): string
    {
        return preg_replace(
            self::PATTERN,
            self::MARK,
            $string,
        );
    }
}
