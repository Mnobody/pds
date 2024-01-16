<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use App\Normalizer\Normalizer\NonAsciiEraser;
use PHPUnit\Framework\TestCase;

class NonAsciiEraserTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function removesNonAsciiSymbols(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new NonAsciiEraser())->normalize($input),
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
