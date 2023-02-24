<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Letter;

class WordTest extends TestCase
{
    /**
     * @test
     */
    public function initializes_correctly(): void
    {
        $this->assertEquals(
            'example',
            (new Word('example'))->word()
        );
    }

    /**
     * @test
     */
    public function returns_correct_length(): void
    {
        $this->assertEquals(
            7,
            (new Word('example'))->length()
        );
    }

    /**
     * @test
     */
    public function ends_with(): void
    {
        $this->assertTrue(
            (new Word('example'))->endsWith('ple')
        );
    }

    /**
     * @test
     */
    public function starts_with(): void
    {
        $this->assertTrue(
            (new Word('example'))->startsWith('exa')
        );
    }

    /**
     * @test
     */
    public function cuts_off_ending(): void
    {
        $this->assertEquals(
            'exam',
            (new Word('example'))->cutOffEnding('ple')->word()
        );
    }

    /**
     * @test
     */
    public function attaches_ending(): void
    {
        $this->assertEquals(
            'example',
            (new Word('exam'))->attachEnding('ple')->word()
        );
    }

    /**
     * @test
     */
    public function replaces_ending(): void
    {
        $this->assertEquals(
            'consolidates',
            (new Word('consolidating'))->replaceEnding('ing', 'es')->word()
        );
    }

    /**
     * @test
     */
    public function cuts_off_last_letter(): void
    {
        $this->assertEquals(
            'exampl',
            (new Word('example'))->cutOffLastLetter()->word()
        );
    }

    /**
     * @test
     */
    public function returns_last_letter(): void
    {
        $this->assertEquals(
            'n',
            (new Word('consolidation'))->lastLetter()->letter()
        );
    }

    /**
     * @test
     */
    public function contains_vowel(): void
    {
        $this->assertTrue((new Word('consolidation'))->containsVowel());
    }

    /**
     * @test
     */
    public function contains_no_vowels(): void
    {
        $this->assertFalse((new Word('brr'))->containsVowel());
    }

    /**
     * @test
     */
    public function determines_supported_length(): void
    {
        $this->assertTrue((new Word('brr'))->isSupportedLength());
    }

    /**
     * @test
     */
    public function determines_not_supported_length(): void
    {
        $this->assertFalse((new Word('am'))->isSupportedLength());
    }

    /**
     * @dataProvider apostrophes
     * @test
     */
    public function trims_leading_apostrophe(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Word($input))->trimLeadingApostrophe()->word()
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
    public function casts_to_uppercase_leading_y(): void
    {
        $this->assertEquals(
            'Yes',
            (new Word('yes'))->castToUppercaseLeadingY()->word()
        );
    }

    /**
     * @test
     */
    public function casts_to_uppercase_y_after_vowel(): void
    {
        $this->assertEquals(
            'boYish',
            (new Word('boyish'))->castToUppercaseYAfterVowel()->word()
        );
    }

    /**
     * @dataProvider hasR1
     * @test
     */
    public function determines_has_r1(string $input): void
    {
        $this->assertTrue(
            (new Word($input))->hasR1()
        );
    }

    public function hasR1(): array
    {
        return [
            ['beautiful'],
            ['agreed'],
            ['agreedly'],
            ['generously']
        ];
    }

    /**
     * @dataProvider hasNoR1
     * @test
     */
    public function determines_has_no_r1(string $input): void
    {
        $this->assertFalse(
            (new Word($input))->hasR1()
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
    public function determines_in_r1(string $input, string $expected): void
    {
        $this->assertTrue(
            (new Word($input))->inR1($expected)
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
    public function determines_not_in_r1(string $input, string $expected): void
    {
        $this->assertFalse(
            (new Word($input))->inR1($expected)
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
    public function determines_when_ends_with_short_syllable(string $input): void
    {
        $this->assertTrue(
            (new Word($input))->endsWithShortSyllable()
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
    public function determines_when_not_ends_with_short_syllable(string $input): void
    {
        $this->assertFalse(
            (new Word($input))->endsWithShortSyllable()
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
    public function splits_word_into_letters(): void
    {
        $this->assertEquals(
            [new Letter('s'), new Letter('o'), new Letter('m'), new Letter('e')],
            (new Word('some'))->letters()
        );
    }

    /**
     * @dataProvider inR2
     * @test
     */
    public function determines_in_r2(string $input, string $expected): void
    {
        $this->assertTrue(
            (new Word($input))->inR2($expected)
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
    public function determines_not_in_r2(string $input, string $expected): void
    {
        $this->assertFalse(
            (new Word($input))->inR2($expected)
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
