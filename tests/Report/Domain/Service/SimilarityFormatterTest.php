<?php

declare(strict_types=1);

namespace Tests\Report\Domain\Service;

use PHPUnit\Framework\TestCase;
use Report\Domain\Service\SimilarityFormatter;

class SimilarityFormatterTest extends TestCase
{
    /**
     * @dataProvider data
     * @test
     */
    public function correctlyFormatesToPercentage(float $input, int $expected): void
    {
        $this->assertEquals(
            $expected,
            (new SimilarityFormatter())->percentage($input),
        );
    }

    public function data(): array
    {
        return [
            [0.02, 2],
            [0.5, 50],
            [0.1, 10],
            [0.42, 42],
            [0.424, 42],
            [1.00, 100],
            [0.565_656_565_656, 57],
            [0.135_5, 14],
        ];
    }
}
