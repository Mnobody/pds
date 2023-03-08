<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Letter;

use App\Shared\Letter\Cyrillic;
use PHPUnit\Framework\TestCase;
use App\Normalizer\Letter\Latin;
use App\Normalizer\Letter\CyrillicToLatinMapper;
use App\Normalizer\Exception\LetterIsNotSupportedException;

class CyrillicToLatinMapperTest extends TestCase
{
    /**
     * @dataProvider letters
     * @test
     */
    public function maps_single_cyrillic_letters($input, $expected): void
    {
        $this->assertEquals(
            $expected,
            (new CyrillicToLatinMapper)->replacement($input)
        );
    }

    public function letters(): array
    {
        return [
            [Cyrillic::LOWERCASE_A, Latin::LOWERCASE_A],
            [Cyrillic::LOWERCASE_E, Latin::LOWERCASE_E],
            [Cyrillic::LOWERCASE_O, Latin::LOWERCASE_O],
            [Cyrillic::LOWERCASE_R, Latin::LOWERCASE_P],
            [Cyrillic::LOWERCASE_S, Latin::LOWERCASE_C],
            [Cyrillic::LOWERCASE_U, Latin::LOWERCASE_Y],
            [Cyrillic::LOWERCASE_H, Latin::LOWERCASE_X],
            [Cyrillic::LOWERCASE_I, Latin::LOWERCASE_I],

            [Cyrillic::UPPERCASE_A, Latin::UPPERCASE_A],
            [Cyrillic::UPPERCASE_V, Latin::UPPERCASE_B],
            [Cyrillic::UPPERCASE_E, Latin::UPPERCASE_E],
            [Cyrillic::UPPERCASE_O, Latin::UPPERCASE_O],
            [Cyrillic::UPPERCASE_O, Latin::UPPERCASE_O],
            [Cyrillic::UPPERCASE_R, Latin::UPPERCASE_P],
            [Cyrillic::UPPERCASE_S, Latin::UPPERCASE_C],
            [Cyrillic::UPPERCASE_T, Latin::UPPERCASE_T],
            [Cyrillic::UPPERCASE_U, Latin::UPPERCASE_Y],
            [Cyrillic::UPPERCASE_H, Latin::UPPERCASE_X],
            [Cyrillic::UPPERCASE_I, Latin::UPPERCASE_I],
            [Cyrillic::UPPERCASE_K, Latin::UPPERCASE_K],
            [Cyrillic::UPPERCASE_K, Latin::UPPERCASE_K],
            [Cyrillic::UPPERCASE_M, Latin::UPPERCASE_M],
            [Cyrillic::UPPERCASE_N, Latin::UPPERCASE_H],
        ];
    }

    /**
     * @test
     */
    public function throws_not_supported_exception(): void
    {
        $this->expectException(LetterIsNotSupportedException::class);
        $this->expectExceptionMessage('Cyrillic letter "ы" is not supported.');

        (new CyrillicToLatinMapper)->replacement('ы');
    }
}
