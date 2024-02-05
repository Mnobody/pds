<?php

declare(strict_types=1);

namespace EnglishStemmer\Domain\Service;

final class Letter
{
    private const VOWELS = ['a', 'e', 'i', 'o', 'u', 'y'];

    private const LI_ENDINGS = ['c', 'd', 'e', 'g', 'h', 'k', 'm', 'n', 'r', 't'];

    public function __construct(private readonly string $letter)
    {
    }

    public function letter(): string
    {
        return $this->letter;
    }

    public function isVowel(): bool
    {
        return in_array($this->letter, self::VOWELS, true);
    }

    public function isValidLiEnding(): bool
    {
        return in_array($this->letter, self::LI_ENDINGS, true);
    }

    public function equals(self $letter): bool
    {
        return $this->letter === $letter->letter();
    }

    public function equalsToOneOf(array $letters): bool
    {
        foreach ($letters as $letter) {
            if (true === $this->equals($letter)) {
                return true;
            }
        }

        return false;
    }
}
