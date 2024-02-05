<?php

declare(strict_types=1);

namespace Normalizer\Domain\Service\Normalizer;

interface NormalizerInterface
{
    public function normalize(string $string): string;
}
