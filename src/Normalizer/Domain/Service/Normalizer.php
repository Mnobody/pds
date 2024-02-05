<?php

declare(strict_types=1);

namespace Normalizer\Domain\Service;

use Normalizer\Domain\Service\Normalizer\DashNormalizer;
use Normalizer\Domain\Service\Normalizer\DotsNormalizer;
use Normalizer\Domain\Service\Normalizer\DoubleQuoteMarkNormalizer;
use Normalizer\Domain\Service\Normalizer\HyperlinkEraser;
use Normalizer\Domain\Service\Normalizer\NewlineNormalizer;
use Normalizer\Domain\Service\Normalizer\NonAsciiEraser;
use Normalizer\Domain\Service\Normalizer\NormalizerInterface;
use Normalizer\Domain\Service\Normalizer\SingleQuoteMarkNormalizer;
use Normalizer\Domain\Service\Normalizer\UnicodeSymbolsEraser;
use Normalizer\Domain\Service\Normalizer\WhitespaceNormalizer;

final class Normalizer
{
    /** @var NormalizerInterface[] */
    private array $normalizers;

    public function __construct()
    {
        $this->normalizers = [
            0 => new WhitespaceNormalizer(),
            1 => new NewlineNormalizer(),
            2 => new HyperlinkEraser(),
            3 => new DashNormalizer(),
            4 => new SingleQuoteMarkNormalizer(),
            5 => new DoubleQuoteMarkNormalizer(),
            6 => new DotsNormalizer(),
            7 => new NonAsciiEraser(),
            8 => new UnicodeSymbolsEraser(),
        ];
    }

    public function normalize(string $string): string
    {
        /** @var NormalizerInterface $normalizer */
        foreach ($this->normalizers as $normalizer) {
            $string = $normalizer->normalize($string);
        }

        return $string;
    }
}
