<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer;

final class Word
{
    private const ONE                      = 1;
    private const TWO                      = 2;
    private const THREE                    = 3;
    private const NO_OFFSET                = 0;
    private const NEGATIVE_ONE             = -1;
    private const NEGATIVE_THREE           = -3;
    private const MINIMAL_SUPPORTED_LENGTH = 2;

    private const APOSTROPHE  = '\'';
    private const LOWERCASE_Y = 'y';
    private const UPPERCASE_Y = 'Y';
    private const LOWERCASE_W = 'w';
    private const LOWERCASE_X = 'x';

    private const GENER_STARTING  = 'gener';
    private const ARSEN_STARTING  = 'arsen';
    private const COMMUN_STARTING = 'commun';

    public function __construct(private readonly string $word)
    {
    }

    public function word(): string
    {
        return $this->word;
    }

    public function length(): int
    {
        return strlen($this->word);
    }

    public function isSupportedLength(): bool
    {
        return strlen($this->word) > self::MINIMAL_SUPPORTED_LENGTH;
    }

    public function endsWith(string $ending): bool
    {
        return str_ends_with($this->word, $ending);
    }

    public function startsWith(string $starting): bool
    {
        return str_starts_with($this->word, $starting);
    }

    public function cutOffEnding(string $ending): self
    {
        return new self(
            substr($this->word, self::NO_OFFSET, -strlen($ending)),
        );
    }

    public function attachEnding(string $ending): self
    {
        return new self(
            implode([$this->word, $ending]),
        );
    }

    public function replaceEnding(string $old, string $new): self
    {
        return new self(
            implode([$this->cutOffEnding($old)->word(), $new]),
        );
    }

    public function cutOffLastLetter(): self
    {
        return new self(
            substr($this->word, self::NO_OFFSET, self::NEGATIVE_ONE),
        );
    }

    public function lastLetter(): Letter
    {
        return new Letter(
            substr($this->word, self::NEGATIVE_ONE),
        );
    }

    public function containsVowel(): bool
    {
        foreach ($this->letters() as $letter) {
            if (true === $letter->isVowel()) {
                return true;
            }
        }

        return false;
    }

    public function trimLeadingApostrophe(): self
    {
        $letters = $this->letters();

        $first = reset($letters);

        if (true === $first->equals(new Letter(self::APOSTROPHE))) {
            unset($letters[key($letters)]);
        }

        return new self(
            $this->implodeLetters($letters),
        );
    }

    public function castToUppercaseLeadingY(): self
    {
        $letters = $this->letters();

        $first = reset($letters);

        if (true === $first->equals(new Letter(self::LOWERCASE_Y))) {
            $letters[key($letters)] = new Letter(self::UPPERCASE_Y);
        }

        return new self(
            $this->implodeLetters($letters),
        );
    }

    public function castToUppercaseYAfterVowel(): self
    {
        $letters = $this->letters();

        $previous = reset($letters);

        while (($current = next($letters)) instanceof Letter) {
            if (true === $current->equals(new Letter(self::LOWERCASE_Y)) && true === $previous->isVowel()) {
                $letters[key($letters)] = new Letter(self::UPPERCASE_Y);
            }

            $previous = $current;
        }

        return new self(
            $this->implodeLetters($letters),
        );
    }

    public function hasR1(): bool
    {
        return strlen($this->getR1()) >= self::ONE;
    }

    public function inR1(string $ending): bool
    {
        return str_ends_with($this->getR1(), $ending);
    }

    public function inR2(string $ending): bool
    {
        return str_ends_with($this->getR2(), $ending);
    }

    public function endsWithShortSyllable(): bool
    {
        $letters = $this->letters();

        // b) - a vowel at the beginning of the word followed by a non-vowel
        if (self::TWO === count($letters)) {
            list($first, $second) = array_slice($letters, self::NO_OFFSET, self::TWO);
            if (true === $first->isVowel() && false === $second->isVowel()) {
                return true;
            }
        }

        // a) - a vowel followed by a non-vowel other than 'w', 'x' or 'Y' and preceded by a non-vowel
        if (count($letters) >= self::THREE) {
            list($preceding, $letter, $following) = array_slice($letters, self::NEGATIVE_THREE, self::THREE);

            $list = [
                new Letter(self::LOWERCASE_W),
                new Letter(self::LOWERCASE_X),
                new Letter(self::UPPERCASE_Y),
            ];

            if (
                false === $preceding->isVowel()
                && true === $letter->isVowel()
                && false === $following->isVowel()
                && false === $following->equalsToOneOf($list)
            ) {
                return true;
            }
        }

        return false;
    }

    public function letters(): array
    {
        return array_map(
            static fn ($char) => new Letter($char),
            mb_str_split($this->word),
        );
    }

    private function getR1(): string
    {
        foreach ([self::GENER_STARTING, self::ARSEN_STARTING, self::COMMUN_STARTING] as $starting) {
            if (true === $this->startsWith($starting)) {
                return substr($this->word, strlen($starting));
            }
        }

        $r1 = [];

        $track = false;

        $letters = $this->letters();

        $previous = reset($letters);

        while (($current = next($letters)) instanceof Letter) {
            if (true === $track) {
                $r1[] = $current;
            }

            if (false === $current->isVowel() && true === $previous->isVowel()) {
                $track = true;
            }

            $previous = $current;
        }

        return $this->implodeLetters($r1);
    }

    private function getR2(): string
    {
        $r2 = [];

        $track = false;

        $letters = (new self($this->getR1()))->letters();

        $previous = reset($letters);

        while (($current = next($letters)) instanceof Letter) {
            if (true === $track) {
                $r2[] = $current;
            }

            if (false === $current->isVowel() && true === $previous->isVowel()) {
                $track = true;
            }

            $previous = $current;
        }

        return $this->implodeLetters($r2);
    }

    private function implodeLetters(array $letters): string
    {
        return implode(
            array_map(
                static fn ($letter) => $letter->letter(),
                $letters,
            ),
        );
    }
}
