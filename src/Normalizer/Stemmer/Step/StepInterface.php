<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Word;

interface StepInterface
{
    public function __invoke(Word $word): Word;
}
