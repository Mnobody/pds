<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Letter;

final class Step4 implements StepInterface
{
    private const DELETES = [
        'ement', 'ance', 'ence', 'able', 'ible', 'ment',
        'ant', 'ent', 'ism', 'ate', 'iti', 'ous', 'ive', 'ize',
        'er', 'al', 'ic',
    ];

    private const ION_ENDING = 'ion';
    private const LOWERCASE_S = 's';
    private const LOWERCASE_T = 't';

    public function __invoke(Word $word): Word
    {
        foreach (self::DELETES as $ending) {
            if ($word->endsWith($ending)) {
                return $word->inR2($ending)
                    ? $word->cutOffEnding($ending)
                    : $word;
            }
        }

        if ($word->endsWith(self::ION_ENDING) && $word->inR2(self::ION_ENDING)) {
            $shortened = $word->cutOffEnding(self::ION_ENDING);

            $list = [new Letter(self::LOWERCASE_S), new Letter(self::LOWERCASE_T)];

            if ($shortened->lastLetter()->equalsToOneOf($list)) {
                return $shortened;
            }
        }

        return $word;
    }
}
