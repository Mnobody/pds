<?php

declare(strict_types=1);

namespace EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Letter;
use EnglishStemmer\Domain\Service\Word;

final class Step2 implements StepInterface
{
    private const REPLACEMENTS = [
        'ization' => 'ize',
        'ational' => 'ate',
        'fulness' => 'ful',
        'ousness' => 'ous',
        'iveness' => 'ive',
        'tional'  => 'tion',
        'biliti'  => 'ble',
        'lessli'  => 'less',
        'ation'   => 'ate',
        'iviti'   => 'ive',
        'aliti'   => 'al',
        'alism'   => 'al',
        'ousli'   => 'ous',
        'fulli'   => 'ful',
        'entli'   => 'ent',
        'enci'    => 'ence',
        'anci'    => 'ance',
        'abli'    => 'able',
        'izer'    => 'ize',
        'ator'    => 'ate',
        'alli'    => 'al',
        'bli'     => 'ble',
    ];

    private const L_ENDING   = 'l';
    private const LI_ENDING  = 'li';
    private const OG_ENDING  = 'og';
    private const OGI_ENDING = 'ogi';

    public function __invoke(Word $word): Word
    {
        foreach (self::REPLACEMENTS as $ending => $replacement) {
            if (true === $word->endsWith($ending)) {
                return (true === $word->inR1($ending))
                    ? $word->replaceEnding($ending, $replacement)
                    : $word;
            }
        }

        // 'ogi' => 'og', //  if preceded by l
        if (true === $word->endsWith(self::OGI_ENDING)) {
            $shortened = $word->cutOffEnding(self::OGI_ENDING);
            if (true === $shortened->lastLetter()->equals(new Letter(self::L_ENDING))) {
                return $shortened->attachEnding(self::OG_ENDING);
            }
        }

        if (true === $word->endsWith(self::LI_ENDING) && true === $word->inR1(self::LI_ENDING)) {
            $shortened = $word->cutOffEnding(self::LI_ENDING);
            if (true === $shortened->lastLetter()->isValidLiEnding()) {
                return $shortened;
            }
        }

        return $word;
    }
}
