<?php

declare(strict_types=1);

namespace App\Normalizer\Stemmer;

use App\Normalizer\Stemmer\Step\Step0;
use App\Normalizer\Stemmer\Step\Step2;
use App\Normalizer\Stemmer\Step\Step3;
use App\Normalizer\Stemmer\Step\Step4;
use App\Normalizer\Stemmer\Step\Step5;
use App\Normalizer\Stemmer\Step\Step1a;
use App\Normalizer\Stemmer\Step\Step1b;
use App\Normalizer\Stemmer\Step\Step1c;
use App\Normalizer\Stemmer\Step\FinalStep;
use App\Normalizer\Stemmer\Step\PrepareStep;
use App\Normalizer\Stemmer\Step\StepInterface;

/**
 * Implementation of the Porter2 Stemming Algorithm for English
 *
 * @see http://snowball.tartarus.org/algorithms/english/stemmer.html
 */
final class Stemmer
{
    private const EXCEPTIONAL_FORMS = [
        'skis' => 'ski',
        'skies' => 'sky',
        'dying' => 'die',
        'lying' => 'lie',
        'tying' => 'tie',
        'idly' => 'idl',
        'gently' => 'gentl',
        'ugly' => 'ugli',
        'early' => 'earli',
        'only' => 'onli',
        'singly' => 'singl',

        'sky' => 'sky',
        'news' => 'news',
        'howe' => 'howe',
        'atlas' => 'atlas',
        'cosmos' => 'cosmos',
        'bias' => 'bias',
        'andes' => 'andes'
    ];

    /**
     * @var StepInterface[]
     */
    private array $steps;

    public function __construct()
    {
        $this->steps = [
            0 => new PrepareStep,
            1 => new Step0,
            2 => new Step1a,
            3 => new Step1b,
            4 => new Step1c,
            5 => new Step2,
            6 => new Step3,
            7 => new Step4,
            8 => new Step5,
            9 => new FinalStep,
        ];
    }

    public function stem(string $string): string
    {
        $word = new Word($string);

        return !$word->isSupportedLength()
            ? $string
            : self::EXCEPTIONAL_FORMS[$string] ?? $this->process($word);
    }

    private function process(Word $word): string
    {
        foreach ($this->steps as $step) {
            $word = $step($word);
        }

        return $word->word();
    }
}
