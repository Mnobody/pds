<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer;

use App\Normalizer\Stemmer\Letter;
use App\Normalizer\Stemmer\Word;
use PHPUnit\Framework\TestCase;

class WordTest extends TestCase
{
    /**
     * @test
     */
    public function initializesCorrectly(): void
    {
        $this->assertEquals(
            'example',
            (new Word('example'))->word(),
        );
    }

    /**
     * @test
     */
    public function returnsCorrectLength(): void
    {
        $this->assertEquals(
            7,
            (new Word('example'))->length(),
        );
    }

    /**
     * @test
     */
    public function endsWith(): void
    {
        $this->assertTrue(
            (new Word('example'))->endsWith('ple'),
        );
    }

    /**
     * @test
     */
    public function startsWith(): void
    {
        $this->assertTrue(
            (new Word('example'))->startsWith('exa'),
        );
    }

    /**
     * @test
     */
    public function cutsOffEnding(): void
    {
        $this->assertEquals(
            'exam',
            (new Word('example'))->cutOffEnding('ple')->word(),
        );
    }

    /**
     * @test
     */
    public function attachesEnding(): void
    {
        $this->assertEquals(
            'example',
            (new Word('exam'))->attachEnding('ple')->word(),
        );
    }

    /**
     * @test
     */
    public function replacesEnding(): void
    {
        $this->assertEquals(
            'consolidates',
            (new Word('consolidating'))->replaceEnding('ing', 'es')->word(),
        );
    }

    /**
     * @test
     */
    public function cutsOffLastLetter(): void
    {
        $this->assertEquals(
            'exampl',
            (new Word('example'))->cutOffLastLetter()->word(),
        );
    }

    /**
     * @test
     */
    public function returnsLastLetter(): void
    {
        $this->assertEquals(
            'n',
            (new Word('consolidation'))->lastLetter()->letter(),
        );
    }

    /**
     * @test
     */
    public function containsVowel(): void
    {
        $this->assertTrue((new Word('consolidation'))->containsVowel());
    }

    /**
     * @test
     */
    public function containsNoVowels(): void
    {
        $this->assertFalse((new Word('brr'))->containsVowel());
    }

    /**
     * @test
     */
    public function determinesSupportedLength(): void
    {
        $this->assertTrue((new Word('brr'))->isSupportedLength());
    }

    /**
     * @test
     */
    public function determinesNotSupportedLength(): void
    {
        $this->assertFalse((new Word('am'))->isSupportedLength());
    }

    /**
     * @dataProvider apostrophes
     * @test
     */
    public function trimsLeadingApostrophe(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Word($input))->trimLeadingApostrophe()->word(),
        );
    }

    public function apostrophes(): array
    {
        return [
            ['\'am', 'am'],
            ['\'\'\'', '\'\''],
        ];
    }

    /**
     * @test
     */
    public function castsToUppercaseLeadingY(): void
    {
        $this->assertEquals(
            'Yes',
            (new Word('yes'))->castToUppercaseLeadingY()->word(),
        );
    }

    /**
     * @test
     */
    public function castsToUppercaseYAfterVowel(): void
    {
        $this->assertEquals(
            'boYish',
            (new Word('boyish'))->castToUppercaseYAfterVowel()->word(),
        );
    }

    /**
     * @dataProvider hasR1
     * @test
     */
    public function determinesHasR1(string $input): void
    {
        $this->assertTrue(
            (new Word($input))->hasR1(),
        );
    }

    public function hasR1(): array
    {
        return [
            ['beautiful'],
            ['agreed'],
            ['agreedly'],
            ['generously'],
        ];
    }

    /**
     * @dataProvider hasNoR1
     * @test
     */
    public function determinesHasNoR1(string $input): void
    {
        $this->assertFalse(
            (new Word($input))->hasR1(),
        );
    }

    public function hasNoR1(): array
    {
        return [
            ['beaut'],
            ['ned'],
            ['shop'],
        ];
    }

    /**
     * @dataProvider inR1
     * @test
     */
    public function determinesInR1(string $input, string $expected): void
    {
        $this->assertTrue(
            (new Word($input))->inR1($expected),
        );
    }

    public function inR1(): array
    {
        return [
            ['beautiful', 'ful'],
            ['beautiful', 'ul'],
            ['beautiful', 'l'],
            ['agreed', 'reed'],
            ['agreedly', 'reedly'],
            ['generously', 'ously'],
        ];
    }

    /**
     * @dataProvider notInR1
     * @test
     */
    public function determinesNotInR1(string $input, string $expected): void
    {
        $this->assertFalse(
            (new Word($input))->inR1($expected),
        );
    }

    public function notInR1(): array
    {
        return [
            ['beautiful', 'tiful'],
            ['beaut', 't'],
            ['cheer', 'r'],
            ['generously', 'rously'],
        ];
    }

    /**
     * @dataProvider endsWithShortSyllable
     * @test
     */
    public function determinesWhenEndsWithShortSyllable(string $input): void
    {
        $this->assertTrue(
            (new Word($input))->endsWithShortSyllable(),
        );
    }

    public function endsWithShortSyllable(): array
    {
        return [
            ['rap'],
            ['trap'],
            ['entrap'],
            ['ow'],
            ['on'],
            ['at'],
        ];
    }

    /**
     * @dataProvider notEndsWithShortSyllable
     * @test
     */
    public function determinesWhenNotEndsWithShortSyllable(string $input): void
    {
        $this->assertFalse(
            (new Word($input))->endsWithShortSyllable(),
        );
    }

    public function notEndsWithShortSyllable(): array
    {
        return [
            ['uproot'],
            ['bestow'],
            ['disturb'],
        ];
    }

    /**
     * @test
     */
    public function splitsWordIntoLetters(): void
    {
        $this->assertEquals(
            [new Letter('s'), new Letter('o'), new Letter('m'), new Letter('e')],
            (new Word('some'))->letters(),
        );
    }

    /**
     * @dataProvider inR2
     * @test
     */
    public function determinesInR2(string $input, string $expected): void
    {
        $this->assertTrue(
            (new Word($input))->inR2($expected),
        );
    }

    public function inR2(): array
    {
        return [
            ['beautiful', 'ul'],
            ['beautiful', 'l'],
            ['boroughbridge', 'hbridge'],
            ['boroughbridge', 'idge'],
        ];
    }

    /**
     * @dataProvider notInR2
     * @test
     */
    public function determinesNotInR2(string $input, string $expected): void
    {
        $this->assertFalse(
            (new Word($input))->inR2($expected),
        );
    }

    public function notInR2(): array
    {
        return [
            ['beautiful', 'ful'],
            ['boroughbridge', 'ghbridge'],
            ['generous', 'ous'],
        ];
    }
}
