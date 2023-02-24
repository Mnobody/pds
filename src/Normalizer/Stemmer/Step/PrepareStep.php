<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Word;

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
