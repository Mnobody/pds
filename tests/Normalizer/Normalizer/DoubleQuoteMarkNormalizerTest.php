<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use App\Normalizer\Normalizer\DoubleQuoteMarkNormalizer;
use PHPUnit\Framework\TestCase;

class DoubleQuoteMarkNormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function replacesUnicodeDoubleQuoteMarksWithSimpleOne(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new DoubleQuoteMarkNormalizer())->normalize($input),
        );
    }

    public function strings(): array
    {
        return [
            ['«something»', '"something"'],
            ['“something”', '"something"'],
            ['„something‟', '"something"'],
            ['\'\'something\'\'', '"something"'],
            ['``something``', '"something"'],
        ];
    }
}
