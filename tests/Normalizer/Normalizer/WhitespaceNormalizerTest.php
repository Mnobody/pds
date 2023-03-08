<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Normalizer\WhitespaceNormalizer;

class WhitespaceNormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function replaces_whitespaces_with_single_space(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new WhitespaceNormalizer)->normalize($input)
        );
    }

    public function strings(): array
    {
        return [
            ['  ', ' '],
            ['   ', ' '],
            ['two  space', 'two space'],
            ['three   space', 'three space'],
            ['three   space   ', 'three space '],
            ['three   space   end', 'three space end'],

            ['tab   space', 'tab space'],
            ['two       tab', 'two tab'],
            ['two       tab space', 'two tab space'],

            ['tab' . "\t", 'tab '],
            ['tab' . "\t\t", 'tab '],
            ['tab' . "\t\t\t", 'tab '],
            ['carriage return' . "\r", 'carriage return '],
            ['carriage return' . "\r\r", 'carriage return '],
            ['carriage return' . "\r\r\r", 'carriage return '],
            ['form feed' . "\f", 'form feed '],
            ['form feed' . "\f\f", 'form feed '],
            ['form feed' . "\f\f\f", 'form feed '],
        ];
    }
}
