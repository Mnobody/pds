<?php

declare(strict_types=1);

namespace App\Similarity\Sentence;

use App\Boundary\WordBreaker;

final class VectorSpaceBuilder
{
    private const ZERO = 0;
    private const ONE  = 1;

    public function __construct(private readonly WordBreaker $breaker)
    {
    }

    public function build(array $sentences): array
    {
        $space = [];

        $initialRow = $this->initialRow($sentences);

        foreach ($sentences as $sentence) {
            $row = $initialRow;

            $batch = $this->breaker->break($sentence);

            foreach ($batch as $word) {
                $row[$word] = $this->idf($word, $sentences);
            }

            $space[$sentence] = $row;
        }

        return $space;
    }

    private function initialRow(array $sentences): array
    {
        $words = [];

        foreach ($sentences as $sentence) {
            $batch = $this->breaker->break($sentence);

            foreach ($batch as $word) {
                if (false === array_key_exists($word, $words)) {
                    $words[$word] = self::ZERO;
                }
            }
        }

        return $words;
    }

    private function idf(string $word, array $sentences): float
    {
        $df = $this->df($word, $sentences);

        return log(count($sentences) / $df);
    }

    private function df(string $word, array $sentences): int
    {
        $frequency = self::ZERO;

        foreach ($sentences as $sentence) {
            $batch = $this->breaker->break($sentence);

            if (true === in_array($word, $batch, true)) {
                $frequency += self::ONE;
            }
        }

        return $frequency;
    }
}
