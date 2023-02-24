<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Letter;

final class Step1c implements StepInterface
{
    private const TWO = 2;
    private const NEGATIVE_TWO = -2;
    private const LOWERCASE_Y = 'y';
    private const UPPERCASE_Y = 'Y';
    private const LOWERCASE_I = 'i';

    public function __invoke(Word $word): Word
    {
        $letters = $word->letters();

        if (count($letters) <= self::TWO) {
            return $word;
        }

        list($preceding, $last) = array_slice($letters, self::NEGATIVE_TWO, self::TWO);

        $list = [
            new Letter(self::LOWERCASE_Y),
            new Letter(self::UPPERCASE_Y)
        ];

        if (!$preceding->isVowel() && $last->equalsToOneOf($list)) {
            return $word->replaceEnding($word->lastLetter()->letter(), self::LOWERCASE_I);
        }

        return $word;
    }
}
