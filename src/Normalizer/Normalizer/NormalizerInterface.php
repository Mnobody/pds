<?php

declare(strict_types=1);

namespace App\Normalizer\Normalizer;

interface NormalizerInterface
{
    public function normalize(string $string): string;
}
