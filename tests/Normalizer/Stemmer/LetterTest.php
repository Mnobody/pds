<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer;

use App\Normalizer\Stemmer\Letter;
use PHPUnit\Framework\TestCase;

class LetterTest extends TestCase
{
    /**
     * @test
     */
    public function initializesCorrectly(): void
    {
        $letter = new Letter('c');

        $this->assertEquals('c', $letter->letter());
    }

    /**
     * @dataProvider vowels
     * @test
     */
    public function recognizesVowels($input): void
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
    public function recognizesLiEndings($input): void
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
    public function recognizesSameLetters(): void
    {
        $this->assertTrue(
            (new Letter('c'))->equals(
                new Letter('c'),
            ),
        );
    }

    /**
     * @test
     */
    public function recognizesDifferentLetters(): void
    {
        $this->assertFalse(
            (new Letter('a'))->equals(
                new Letter('b'),
            ),
        );
    }

    /**
     * @test
     */
    public function recognizesSameLetterInList(): void
    {
        $this->assertTrue(
            (new Letter('b'))->equalsToOneOf([
                new Letter('a'),
                new Letter('b'),
            ]),
        );
    }
}
