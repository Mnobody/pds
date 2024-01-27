<?php

declare(strict_types=1);

namespace App\Similarity\Sentence;

final class VectorSpaceNormalizer
{
    private const ZERO     = 0;
    private const EXPONENT = 2;

    public function normalize(array $space): array
    {
        foreach ($space as $sentence => $words) {
            $sum = self::ZERO;

            foreach ($words as $weight) {
                $sum += pow($weight, self::EXPONENT);
            }

            $sqrt = sqrt($sum);

            foreach ($words as $word => $weight) {
                $space[$sentence][$word] /= $sqrt;
            }
        }

        return $space;
    }
}
