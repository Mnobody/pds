<?php

declare(strict_types=1);

namespace App\Tests\Similarity\Text;

use App\Similarity\SimilarityFormatter;
use App\Similarity\Text\TextComparator;
use PHPUnit\Framework\TestCase;

class TextComparatorTest extends TestCase
{
    /**
     * @dataProvider data
     * @test
     */
    public function correctlyCalculatesSimilarityBetweenTexts(array $input, int $expected): void
    {
        $this->assertEquals(
            $expected,
            (new TextComparator(new SimilarityFormatter()))->compare($input['first'], $input['second']),
        );
    }

    public function data(): array
    {
        return [
            [
                [
                    'first'  => ['one' => 1, 'two' => 1, 'three' => 1],
                    'second' => ['four' => 1, 'five' => 1, 'six' => 1],
                ],
                0,
            ],
            [
                [
                    'first'  => ['one' => 1, 'two' => 1, 'three' => 1],
                    'second' => ['one' => 1, 'two' => 1, 'three' => 1],
                ],
                100,
            ],
            [
                [
                    'first'  => ['one' => 1, 'two' => 2, 'three' => 3],
                    'second' => ['one' => 1, 'two' => 2, 'three' => 3],
                ],
                100,
            ],
            [
                [
                    'first'  => ['one' => 1, 'two' => 2, 'three' => 3, 'four' => 1],
                    'second' => ['one' => 1, 'two' => 1, 'five' => 1, 'six' => 4],
                ],
                18,
            ],
            [
                [
                    'first'  => ['one' => 1, 'two' => 2, 'three' => 3, 'four' => 1],
                    'second' => ['one' => 1, 'two' => 1, 'three' => 1, 'five' => 1, 'six' => 2, 'seven' => 3],
                ],
                38,
            ],
            [
                [
                    'first'  => ['one' => 1, 'two' => 2, 'three' => 3, 'four' => 1],
                    'second' => ['one' => 1, 'two' => 1, 'three' => 2, 'five' => 1, 'six' => 1, 'seven' => 5],
                ],
                40,
            ],
            [
                [
                    'first'  => ['one' => 1, 'two' => 2, 'three' => 3, 'four' => 1],
                    'second' => ['one' => 1, 'two' => 1, 'three' => 2, 'five' => 1, 'six' => 3, 'seven' => 4],
                ],
                41,
            ],
            [
                [
                    'first'  => ['one' => 1, 'two' => 2, 'three' => 3, 'four' => 1],
                    'second' => ['one' => 1, 'two' => 1, 'three' => 1, 'five' => 1],
                ],
                77,
            ],
        ];
    }
}
