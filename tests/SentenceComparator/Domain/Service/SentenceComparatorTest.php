<?php

declare(strict_types=1);

namespace Tests\SentenceComparator\Domain\Service;

use PHPUnit\Framework\TestCase;
use SentenceComparator\Domain\Service\SentenceComparator;
use SentenceComparator\Domain\Service\VectorSpaceBuilder;
use SentenceComparator\Domain\Service\VectorSpaceNormalizer;
use Shared\Domain\Service\WordBreaker;

class SentenceComparatorTest extends TestCase
{
    /** @var array<string,array<string,float>> */
    private array $normalizedVectorSpaceForData = [];

    /**
     * @dataProvider data
     * @test
     */
    public function correctlyCalculatesSimilarityBetweenSentences(array $input, int $expected): void
    {
        $similarity = (new SentenceComparator(new WordBreaker()))->compare(
            $input['first'],
            $input['second'],
            $this->normalizedVectorSpaceForData,
        );

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
                    'first'  => 'one two three',
                    'second' => 'four five six',
                ],
                0,
            ],
            [
                [
                    'first'  => 'one two three',
                    'second' => 'one two three',
                ],
                100,
            ],
            [
                [
                    'first'  => 'one two two three three three',
                    'second' => 'one two two three three three',
                ],
                100,
            ],
            [
                [
                    'first'  => 'one one two three four',
                    'second' => 'one two five six',
                ],
                1,
            ],
            [
                [
                    'first'  => 'one two three four',
                    'second' => 'one two three five six seven',
                ],
                2,
            ],
            [
                [
                    'first'  => 'one two three four',
                    'second' => 'one two three four six seven eight',
                ],
                26,
            ],
            [
                [
                    'first'  => 'one two three four five six',
                    'second' => 'one two three five seven',
                ],
                44,
            ],
            [
                [
                    'first'  => 'one two three four',
                    'second' => 'one two three four six seven',
                ],
                46,
            ],
            [
                [
                    'first'  => 'one two three four five six seven eight',
                    'second' => 'one two three five six seven',
                ],
                59,
            ],
        ];
    }

    protected function setUp(): void
    {
        $all = [];

        foreach ($this->data() as $datum) {
            $all[] = $datum[0]['first'];
            $all[] = $datum[0]['second'];
        }

        $this->normalizedVectorSpaceForData = (new VectorSpaceNormalizer())->normalize(
            (new VectorSpaceBuilder(new WordBreaker()))->build($all),
        );
    }
}
