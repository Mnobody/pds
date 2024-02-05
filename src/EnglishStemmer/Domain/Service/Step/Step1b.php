<?php

declare(strict_types=1);

namespace EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Word;

final class Step1b implements StepInterface
{
    private const EXCEPTIONS = [
        'inning', 'outing', 'canning', 'herring', 'earring',
        'proceed', 'exceed', 'succeed',
    ];

    private const DOUBLES = [
        'bb', 'dd', 'ff', 'gg', 'mm', 'nn', 'pp', 'rr', 'tt',
    ];

    private const EE_ENDING    = 'ee';
    private const EED_ENDING   = 'eed';
    private const EEDLY_ENDING = 'eedly';

    private const INGLY_ENDING = 'ingly';
    private const EDLY_ENDING  = 'edly';
    private const ING_ENDING   = 'ing';
    private const ED_ENDING    = 'ed';

    private const AT_ENDING = 'at';
    private const BL_ENDING = 'bl';
    private const IZ_ENDING = 'iz';

    private const E_ENDING = 'e';

    public function __invoke(Word $word): Word
    {
        if (true === in_array($word->word(), self::EXCEPTIONS, true)) {
            return $word;
        }

        return match (true) {
            $this->endsWithEED($word) => $this->replaceEEDEnding($word),
            $this->endsWithEEDLY($word) => $this->replaceEEDLYEnding($word),

            $this->endsWithED($word) => $this->replaceEDEnding($word),
            $this->endsWithEDLY($word) => $this->replaceEDLYEnding($word),
            $this->endsWithING($word) => $this->replaceINGEnding($word),
            $this->endsWithINGLY($word) => $this->replaceINGLYEnding($word),

            default => $word,
        };
    }

    private function endsWithEED(Word $word): bool
    {
        return $word->endsWith(self::EED_ENDING);
    }

    private function replaceEEDEnding(Word $word): Word
    {
        return (true === $word->inR1(self::EED_ENDING))
            ? $word->replaceEnding(self::EED_ENDING, self::EE_ENDING)
            : $word;
    }

    private function endsWithEEDLY(Word $word): bool
    {
        return $word->endsWith(self::EEDLY_ENDING);
    }

    private function replaceEEDLYEnding(Word $word): Word
    {
        return (true === $word->inR1(self::EEDLY_ENDING))
            ? $word->replaceEnding(self::EEDLY_ENDING, self::EE_ENDING)
            : $word;
    }

    private function endsWithED(Word $word): bool
    {
        return $word->endsWith(self::ED_ENDING);
    }

    private function replaceEDEnding(Word $word): Word
    {
        return $this->processEndings($word, self::ED_ENDING);
    }

    private function endsWithEDLY(Word $word): bool
    {
        return $word->endsWith(self::EDLY_ENDING);
    }

    private function replaceEDLYEnding(Word $word): Word
    {
        return $this->processEndings($word, self::EDLY_ENDING);
    }

    private function endsWithING(Word $word): bool
    {
        return $word->endsWith(self::ING_ENDING);
    }

    private function replaceINGEnding(Word $word): Word
    {
        return $this->processEndings($word, self::ING_ENDING);
    }

    private function endsWithINGLY(Word $word): bool
    {
        return $word->endsWith(self::INGLY_ENDING);
    }

    private function replaceINGLYEnding(Word $word): Word
    {
        return $this->processEndings($word, self::INGLY_ENDING);
    }

    private function processEndings(Word $word, string $ending): Word
    {
        $shortened = $word->cutOffEnding($ending);

        if (false === $shortened->containsVowel()) {
            return $word;
        }

        foreach ([self::AT_ENDING, self::BL_ENDING, self::IZ_ENDING] as $ending) {
            if (true === $shortened->endsWith($ending)) {
                return $shortened->attachEnding(self::E_ENDING);
            }
        }

        if (true === $this->endsWithDouble($shortened)) {
            return $shortened->cutOffLastLetter();
        }

        if (true === $this->isShort($shortened)) {
            return $shortened->attachEnding(self::E_ENDING);
        }

        return $shortened;
    }

    private function endsWithDouble(Word $word): bool
    {
        foreach (self::DOUBLES as $double) {
            if (true === $word->endsWith($double)) {
                return true;
            }
        }

        return false;
    }

    private function isShort(Word $word): bool
    {
        return $word->endsWithShortSyllable() && !$word->hasR1();
    }
}
