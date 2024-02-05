<?php

declare(strict_types=1);

namespace Tests\DocumentComparator\Domain\Service;

use DocumentComparator\Domain\Service\DocumentComparator;
use PHPUnit\Framework\TestCase;

class DocumentComparatorTest extends TestCase
{
    /**
     * @dataProvider data
     * @test
     */
    public function correctlyCalculatesSimilarityBetweenTexts(array $input, int $expected): void
    {
        $similarity = (new DocumentComparator())->compare($input['first'], $input['second']);

        $this->assertEquals(
            $expected,
            // convert to percentage
            // convert to string to avoid floating point precision issues
            (int) (string) (100 * round($similarity, 2, PHP_ROUND_HALF_UP)),
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
