<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Word;

final class Step0 implements StepInterface
{
    private const ENDINGS_TO_REMOVE = ['\'s\'', '\'s', '\''];

    public function __invoke(Word $word): Word
    {
        foreach (self::ENDINGS_TO_REMOVE as $ending) {
            if ($word->endsWith($ending)) {
                return $word->cutOffEnding($ending);
            }
        }

        return $word;
    }
}
