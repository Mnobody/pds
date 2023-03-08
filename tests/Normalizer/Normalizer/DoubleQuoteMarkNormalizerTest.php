<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Normalizer\DoubleQuoteMarkNormalizer;

class DoubleQuoteMarkNormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function replaces_unicode_double_quote_marks_with_simple_one(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new DoubleQuoteMarkNormalizer)->normalize($input)
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
