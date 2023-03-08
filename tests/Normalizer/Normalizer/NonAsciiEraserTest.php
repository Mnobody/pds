<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Normalizer\NonAsciiEraser;

class NonAsciiEraserTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function removes_non_ascii_symbols(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new NonAsciiEraser)->normalize($input)
        );
    }

    public function strings(): array
    {
        return [
            ['ąa', 'a'],
            ['ąćðżźćŻŹĆÐÐŚÆŚ', ''],
        ];
    }
}
