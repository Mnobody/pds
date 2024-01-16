<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Normalizer\Letter\CyrillicToLatinMapper;
use App\Normalizer\Normalizer\CyrillicNormalizer;
use App\Normalizer\Normalizer\DashNormalizer;
use App\Normalizer\Normalizer\DotsNormalizer;
use App\Normalizer\Normalizer\DoubleQuoteMarkNormalizer;
use App\Normalizer\Normalizer\HyperlinkEraser;
use App\Normalizer\Normalizer\NewlineNormalizer;
use App\Normalizer\Normalizer\NonAsciiEraser;
use App\Normalizer\Normalizer\NormalizerInterface;
use App\Normalizer\Normalizer\SingleQuoteMarkNormalizer;
use App\Normalizer\Normalizer\UnicodeSymbolsEraser;
use App\Normalizer\Normalizer\WhitespaceNormalizer;
use App\Shared\Letter\Cyrillic;

final class Normalizer
{
    /** @var NormalizerInterface[] */
    private array $normalizers;

    public function __construct()
    {
        $this->normalizers = [
            0 => new CyrillicNormalizer(new Cyrillic(), new CyrillicToLatinMapper()),
            1 => new WhitespaceNormalizer(),
            2 => new NewlineNormalizer(),
            3 => new HyperlinkEraser(),
            4 => new DashNormalizer(),
            5 => new SingleQuoteMarkNormalizer(),
            6 => new DoubleQuoteMarkNormalizer(),
            7 => new DotsNormalizer(),
            8 => new NonAsciiEraser(),
            9 => new UnicodeSymbolsEraser(),
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
