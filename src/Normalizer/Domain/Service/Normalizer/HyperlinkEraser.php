<?php

declare(strict_types=1);

namespace Normalizer\Domain\Service\Normalizer;

final class HyperlinkEraser implements NormalizerInterface
{
    private const EMPTY            = '';
    private const PATTERN_PROTOCOL = '/(http|https|ftp|file):\/\/\S+/';
    private const PATTERN_WWW      = '/(www\.\S+)/';

    public function normalize(string $string): string
    {
        return preg_replace(
            [self::PATTERN_PROTOCOL, self::PATTERN_WWW],
            self::EMPTY,
            $string,
        );
    }
}
