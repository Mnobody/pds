<?php

declare(strict_types=1);

namespace EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Word;

interface StepInterface
{
    public function __invoke(Word $word): Word;
}
