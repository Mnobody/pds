<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Word;

final class FinalStep implements StepInterface
{
    public function __invoke(Word $word): Word
    {
        return new Word(
            strtolower($word->word()),
        );
    }
}
