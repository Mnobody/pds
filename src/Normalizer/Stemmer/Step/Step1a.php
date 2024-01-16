<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Word;

final class Step1a implements StepInterface
{
    private const ONE          = 1;
    private const NO_OFFSET    = 0;
    private const NEGATIVE_TWO = -2;

    private const I_ENDING    = 'i';
    private const S_ENDING    = 's';
    private const IE_ENDING   = 'ie';
    private const SS_ENDING   = 'ss';
    private const US_ENDING   = 'us';
    private const IED_ENDING  = 'ied';
    private const IES_ENDING  = 'ies';
    private const SSES_ENDING = 'sses';

    public function __invoke(Word $word): Word
    {
        return match (true) {
            $this->endsWithSSES($word) => $this->replaceSSESEnding($word),
            $this->endsWithIED($word) => $this->replaceIEDEnding($word),
            $this->endsWithIES($word) => $this->replaceIESEnding($word),
            // for suffixes 'us' and 'ss' - do nothing
            $this->endsWithSS($word), $this->endsWithUS($word) => $word,
            $this->endsWithS($word) => $this->cutOffSEnding($word),
            default => $word,
        };
    }

    private function endsWithSSES(Word $word): bool
    {
        return $word->endsWith(self::SSES_ENDING);
    }

    private function replaceSSESEnding(Word $word): Word
    {
        return $word->replaceEnding(self::SSES_ENDING, self::SS_ENDING);
    }

    private function endsWithIED(Word $word): bool
    {
        return $word->endsWith(self::IED_ENDING);
    }

    private function replaceIEDEnding(Word $word): Word
    {
        $replacement = $this->determineIEDAndIESReplacement($word, self::IED_ENDING);

        return $word->replaceEnding(self::IED_ENDING, $replacement);
    }

    private function endsWithIES(Word $word): bool
    {
        return $word->endsWith(self::IES_ENDING);
    }

    private function replaceIESEnding(Word $word): Word
    {
        $replacement = $this->determineIEDAndIESReplacement($word, self::IES_ENDING);

        return $word->replaceEnding(self::IES_ENDING, $replacement);
    }

    private function determineIEDAndIESReplacement(Word $word, string $ending): string
    {
        // replace by 'i' if preceded by more than one letter, otherwise by 'ie'
        return $word->cutOffEnding($ending)->length() > self::ONE
            ? self::I_ENDING
            : self::IE_ENDING;
    }

    private function endsWithSS(Word $word): bool
    {
        return $word->endsWith(self::SS_ENDING);
    }

    private function endsWithUS(Word $word): bool
    {
        return $word->endsWith(self::US_ENDING);
    }

    private function endsWithS(Word $word): bool
    {
        return $word->endsWith(self::S_ENDING);
    }

    private function cutOffSEnding(Word $word): Word
    {
        // if contains a vowel not immediately before the 's'
        $shortened = new Word(
            substr($word->word(), self::NO_OFFSET, self::NEGATIVE_TWO),
        );

        if (true === $shortened->containsVowel()) {
            return $word->cutOffEnding(self::S_ENDING);
        }

        return $word;
    }
}
