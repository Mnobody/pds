<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use App\Normalizer\Normalizer\UnicodeSymbolsEraser;
use PHPUnit\Framework\TestCase;

class UnicodeSymbolsEraserTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function removesUnicodeSymbols(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new UnicodeSymbolsEraser())->normalize($input),
        );
    }

    public function strings(): array
    {
        return [
            ['a', 'a'],
            ["\u{0000}", ''],
            ["\u{0001}", ''],
            ["\u{0002}", ''],
            ["\u{0003}", ''],
            ["\u{0004}", ''],
            ["\u{0005}", ''],
            ["\u{0006}", ''],
            ["\u{0007}", ''],
            ["\u{0008}", ''],
            ["\u{0009}", ''], ['	', ''],
            ["\u{0010}", ''],
            ["\u{0011}", ''],
        ];
    }
}
