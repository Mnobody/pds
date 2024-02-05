<?php

declare(strict_types=1);

namespace Tests\Normalizer\Domain\Service\Normalizer;

use Normalizer\Domain\Service\Normalizer\NonAsciiEraser;
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
