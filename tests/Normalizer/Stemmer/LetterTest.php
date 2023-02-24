<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Letter;

class LetterTest extends TestCase
{
    /**
     * @test
     */
    public function initializes_correctly(): void
    {
        $letter = new Letter('c');

        $this->assertEquals('c', $letter->letter());
    }

    /**
     * @dataProvider vowels
     * @test
     */
    public function recognizes_vowels($input): void
    {
        $letter = new Letter($input);

        $this->assertTrue($letter->isVowel());
    }

    public function vowels(): array
    {
        return [
            ['a'],
            ['e'],
            ['i'],
            ['o'],
            ['u'],
            ['y'],
        ];
    }

    /**
     * @dataProvider liEndings
     * @test
     */
    public function recognizes_li_endings($input): void
    {
        $letter = new Letter($input);

        $this->assertTrue($letter->isValidLiEnding());
    }

    public function liEndings(): array
    {
        return [
            ['c'],
            ['d'],
            ['e'],
            ['g'],
            ['h'],
            ['k'],
            ['m'],
            ['n'],
            ['r'],
            ['t'],
        ];
    }

    /**
     * @test
     */
    public function recognizes_same_letters(): void
    {
        $this->assertTrue(
            (new Letter('c'))->equals(
                new Letter('c')
            )
        );
    }

    /**
     * @test
     */
    public function recognizes_different_letters(): void
    {
        $this->assertFalse(
            (new Letter('a'))->equals(
                new Letter('b')
            )
        );
    }

    /**
     * @test
     */
    public function recognizes_same_letter_in_list(): void
    {
        $this->assertTrue(
            (new Letter('b'))->equalsToOneOf([
                new Letter('a'),
                new Letter('b')
            ])
        );
    }
}
