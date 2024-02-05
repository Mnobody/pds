<?php

declare(strict_types=1);

namespace EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Word;

final class PrepareStep implements StepInterface
{
    public function __invoke(Word $word): Word
    {
        return $word
            ->trimLeadingApostrophe()
            ->castToUppercaseLeadingY()
            ->castToUppercaseYAfterVowel();
    }
}
