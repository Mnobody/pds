<?php

declare(strict_types=1);

namespace Tests\Normalizer\Domain\Service\Normalizer;

use Normalizer\Domain\Service\Normalizer\DoubleQuoteMarkNormalizer;
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
