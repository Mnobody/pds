<?php

declare(strict_types=1);

namespace App\Tests\Normalizer;

use App\Normalizer\CyrillicNormalizer;
use App\Normalizer\CyrillicToLatinMapper;
use App\Normalizer\Letter\Latin;
use App\Shared\Letter\Cyrillic;
use PHPUnit\Framework\TestCase;

class CyrillicNormalizerTest extends TestCase
{
    private CyrillicNormalizer $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new CyrillicNormalizer(
            new Cyrillic,
            new CyrillicToLatinMapper
        );
    }

    /**
     * @dataProvider letters
     * @test
     */
    public function replaces_single_cyrillic_letters($input, $expected): void
    {
        $normalized = $this->normalizer->normalize($input);

        $this->assertEquals($expected, $normalized);
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
     * @dataProvider texts
     * @test
     */
    public function replaces_cyrillic_letters($input, $expected): void
    {
        $normalized = $this->normalizer->normalize($input);

        $this->assertEquals($expected, $normalized);
    }

    public function texts(): array
    {
        return [
            [
                'аеорсухіАВЕОРСТУХІКМН',
                'aeopcyxiABEOPCTYXIKMH'
            ],
            [
                'Lorem Іpsum іs sіmрly dummу text оf thе рrinting аnd tyрesеttіng іndustrу. Richаrd McСlintоck, a Latin рrofessor at Нampdеn-Sydney Сollege in Virginia.',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.'
            ]
        ];
    }
}
