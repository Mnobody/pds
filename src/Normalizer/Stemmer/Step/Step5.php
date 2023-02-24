<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Letter;

final class Step5 implements StepInterface
{
    private const E_ENDING = 'e';
    private const L_ENDING = 'l';

    public function __invoke(Word $word): Word
    {
        if ($word->endsWith(self::E_ENDING)) {
            $shortened = $word->cutOffEnding(self::E_ENDING);

            if ($word->inR2(self::E_ENDING)) {
                return $shortened;
            }

            if ($word->inR1(self::E_ENDING) && !$shortened->endsWithShortSyllable()) {
                return $shortened;
            }
        }

        if ($word->endsWith(self::L_ENDING) && $word->inR2(self::L_ENDING)) {
            $shortened = $word->cutOffEnding(self::L_ENDING);
            if ($shortened->lastLetter()->equals(new Letter(self::L_ENDING))) {
                return $shortened;
            }
        }

        return $word;
    }
}
