<?php

declare(strict_types=1);

namespace Tests\CyrillicNormalizer\Domain\Service;

use CyrillicNormalizer\Domain\Service\CyrillicNormalizer;
use CyrillicNormalizer\Domain\Service\CyrillicToLatinMapper;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Cyrillic;

class CyrillicNormalizerTest extends TestCase
{
    private CyrillicNormalizer $normalizer;

    /**
     * @dataProvider texts
     * @test
     */
    public function replacesCyrillicLetters($input, $expected): void
    {
        $normalized = $this->normalizer->normalize($input);

        $this->assertEquals($expected, $normalized);
    }

    public function texts(): array
    {
        return [
            [
                'аеорсухіАВЕОРСТУХІКМН',
                'aeopcyxiABEOPCTYXIKMH',
            ],
            [
                'Lorem Іpsum іs sіmрly dummу text оf thе рrinting аnd tyрesеttіng іndustrу. Richаrd McСlintоck, a Latin рrofessor at Нampdеn-Sydney Сollege in Virginia.',
                'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.',
            ],
            ['Some text exаmple', 'Some text example'],
        ];
    }

    protected function setUp(): void
    {
        $this->normalizer = new CyrillicNormalizer(
            new Cyrillic(),
            new CyrillicToLatinMapper(),
        );
    }
}
