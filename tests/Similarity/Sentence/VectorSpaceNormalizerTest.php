<?php

declare(strict_types=1);

namespace App\Tests\Similarity\Sentence;

use App\Similarity\Sentence\VectorSpaceNormalizer;
use PHPUnit\Framework\TestCase;

class VectorSpaceNormalizerTest extends TestCase
{
    /**
     * @dataProvider data
     * @test
     */
    public function correctlyNormalizesVectorSpace(array $input, array $expected): void
    {
        $this->assertEquals(
            $expected,
            array_map(
                static fn (array $array) => array_map(
                    static fn (float $value) => round($value, 2),
                    $array,
                ),
                (new VectorSpaceNormalizer())->normalize($input),
            ),
        );
    }

    public function data(): array
    {
        return [
            [
                [
                    'one two three' => ['one' => 0.69, 'two' => 0.69, 'three' => 0.69, 'four' => 0, 'five' => 0, 'six' => 0],
                    'four five six' => ['one' => 0, 'two' => 0, 'three' => 0, 'four' => 0.69, 'five' => 0.69, 'six' => 0.69],
                ],
                [
                    'one two three' => ['one' => 0.58, 'two' => 0.58, 'three' => 0.58, 'four' => 0, 'five' => 0, 'six' => 0],
                    'four five six' => ['one' => 0, 'two' => 0, 'three' => 0, 'four' => 0.58, 'five' => 0.58, 'six' => 0.58],
                ],
            ],
            [
                [
                    'sentence first'  => ['sentence' => 0, 'first' => 0.69, 'second' => 0],
                    'sentence second' => ['sentence' => 0, 'first' => 0, 'second' => 0.69],
                ],
                [
                    'sentence first'  => ['sentence' => 0, 'first' => 1.0, 'second' => 0],
                    'sentence second' => ['sentence' => 0, 'first' => 0, 'second' => 1.0],
                ],
            ],
            [
                [
                    'example sentence first'  => ['example' => 0.41, 'sentence' => 0, 'first' => 1.10, 'second' => 0, 'third' => 0],
                    'example sentence second' => ['example' => 0.41, 'sentence' => 0, 'first' => 0, 'second' => 1.10, 'third' => 0],
                    'sentence third'          => ['example' => 0, 'sentence' => 0, 'first' => 0, 'second' => 0, 'third' => 1.10],
                ],
                [
                    'example sentence first'  => ['example' => 0.35, 'sentence' => 0, 'first' => 0.94, 'second' => 0, 'third' => 0],
                    'example sentence second' => ['example' => 0.35, 'sentence' => 0, 'first' => 0, 'second' => 0.94, 'third' => 0],
                    'sentence third'          => ['example' => 0, 'sentence' => 0, 'first' => 0, 'second' => 0, 'third' => 1.0],
                ],
            ],
            [
                [
                    'example sentence first'  => ['example' => 0.29, 'sentence' => 0, 'first' => 1.39, 'second' => 0, 'third' => 0, 'fourth' => 0],
                    'example sentence second' => ['example' => 0.29, 'sentence' => 0, 'first' => 0, 'second' => 1.39, 'third' => 0, 'fourth' => 0],
                    'example sentence third'  => ['example' => 0.29, 'sentence' => 0, 'first' => 0, 'second' => 0, 'third' => 1.39, 'fourth' => 0],
                    'sentence fourth fourth'  => ['example' => 0, 'sentence' => 0, 'first' => 0, 'second' => 0, 'third' => 0, 'fourth' => 1.39],
                ],
                [
                    'example sentence first'  => ['example' => 0.20, 'sentence' => 0, 'first' => 0.98, 'second' => 0, 'third' => 0, 'fourth' => 0],
                    'example sentence second' => ['example' => 0.20, 'sentence' => 0, 'first' => 0, 'second' => 0.98, 'third' => 0, 'fourth' => 0],
                    'example sentence third'  => ['example' => 0.20, 'sentence' => 0, 'first' => 0, 'second' => 0, 'third' => 0.98, 'fourth' => 0],
                    'sentence fourth fourth'  => ['example' => 0, 'sentence' => 0, 'first' => 0, 'second' => 0, 'third' => 0, 'fourth' => 1.0],
                ],
            ],
        ];
    }
}
