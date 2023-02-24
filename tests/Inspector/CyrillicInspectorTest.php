<?php

declare(strict_types=1);

namespace App\Tests\Inspector;

use PHPUnit\Framework\TestCase;
use App\Shared\Letter\Cyrillic;
use App\Inspector\CyrillicInspector;

class CyrillicInspectorTest extends TestCase
{
    private CyrillicInspector $inspector;

    protected function setUp(): void
    {
        $this->inspector = new CyrillicInspector(new Cyrillic);
    }

    /**
     * @dataProvider textAndCount
     * @test
     */
    public function counts_cyrillic_letters(string $input, int $count): void
    {
        $result = $this->inspector->check($input);

        $this->assertEquals($count, $result->count());
    }

    public function textAndCount(): array
    {
        return [
            ['', 0],
            ['there is no cyrillic letters', 0],
            ['there is оne cyrillic letter', 1],
            ['АВЕ', 3],
            ['АВЕАВЕ', 6],
            ['аеорсухіАВЕОРСТУХІКМН', 21],
            ['Lоrеm Іpsum іs sіmplу. Richard McСlintoсk.', 8]
        ];
    }

    /**
     * @dataProvider textAndHighlight
     * @test
     */
    public function highlights_found_cyrillic_letters(string $input, string $expected): void
    {
        $result = $this->inspector->check($input);

        $this->assertEquals($expected, $result->highlighted());
    }

    public function textAndHighlight(): array
    {
        return [
            ['', ''],
            ['there is no cyrillic letters', ''], // no need to highlight text
            ['there is оne cyrillic letter', 'there is <b>о</b>ne cyrillic letter'],
            ['АВЕ', '<b>А</b><b>В</b><b>Е</b>'],
            ['АВЕАВЕ', '<b>А</b><b>В</b><b>Е</b><b>А</b><b>В</b><b>Е</b>'],
            ['аеорсухіАВЕОРСТУХІКМН', '<b>а</b><b>е</b><b>о</b><b>р</b><b>с</b><b>у</b><b>х</b><b>і</b><b>А</b><b>В</b><b>Е</b><b>О</b><b>Р</b><b>С</b><b>Т</b><b>У</b><b>Х</b><b>І</b><b>К</b><b>М</b><b>Н</b>'],
            ['Lоrеm Іpsum іs sіmplу. Richard McСlintoсk.', 'L<b>о</b>r<b>е</b>m <b>І</b>psum <b>і</b>s s<b>і</b>mpl<b>у</b>. Richard Mc<b>С</b>linto<b>с</b>k.']
        ];
    }
}
