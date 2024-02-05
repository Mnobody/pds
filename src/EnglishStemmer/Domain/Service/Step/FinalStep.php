<?php

declare(strict_types=1);

namespace EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Word;

final class FinalStep implements StepInterface
{
    public function __invoke(Word $word): Word
    {
        return new Word(
            strtolower($word->word()),
        );
    }
}
