<?php

declare(strict_types=1);

namespace App\Normalizer\Normalizer;

use App\Shared\Letter\Cyrillic;
use App\Normalizer\Letter\CyrillicToLatinMapper;

final class CyrillicNormalizer implements NormalizerInterface
{
    public function __construct(
        private readonly Cyrillic $cyrillic,
        private readonly CyrillicToLatinMapper $mapper
    )
    {
    }

    public function normalize(string $string): string
    {
        $result = $string;

        foreach ($this->cyrillic->letters() as $cyrillic) {
            $result = str_replace(
                $cyrillic,
                $this->mapper->replacement($cyrillic),
                $result
            );
        }

        return $result;
    }

}
