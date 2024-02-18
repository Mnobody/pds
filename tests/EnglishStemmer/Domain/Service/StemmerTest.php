<?php

declare(strict_types=1);

namespace Tests\EnglishStemmer\Domain\Service;

use EnglishStemmer\Domain\Service\Stemmer;
use PHPUnit\Framework\TestCase;

class StemmerTest extends TestCase
{
    /**
     * @dataProvider letters
     * @test
     */
    public function worksCorrectlyForSmallSample($input, $expected): void
    {
        $stemmed = (new Stemmer())->stem($input);

        $this->assertEquals($expected, $stemmed);
    }

    public function letters(): array
    {
        return [
            ['\'\'\'', '\''],
            ['a', 'a'],
            ['skis', 'ski'],
            ['sky', 'sky'],
            ['consign', 'consign'],
            ['consigned', 'consign'],
            ['consigning', 'consign'],
            ['consignment', 'consign'],
            ['consist', 'consist'],
            ['consisted', 'consist'],
            ['consistency', 'consist'],
            ['consistent', 'consist'],
            ['consistently', 'consist'],
            ['consisting', 'consist'],
            ['consists', 'consist'],
            ['consolation', 'consol'],
            ['consolations', 'consol'],
            ['consolatory', 'consolatori'],
            ['console', 'consol'],
            ['consoled', 'consol'],
            ['consoles', 'consol'],
            ['consolidate', 'consolid'],
            ['consolidated', 'consolid'],
            ['consolidating', 'consolid'],
            ['consoling', 'consol'],
            ['consolingly', 'consol'],
            ['consols', 'consol'],
            ['consonant', 'conson'],
            ['consort', 'consort'],
            ['consorted', 'consort'],
            ['consorting', 'consort'],
            ['conspicuous', 'conspicu'],
            ['conspicuously', 'conspicu'],
            ['conspiracy', 'conspiraci'],
            ['conspirator', 'conspir'],
            ['conspirators', 'conspir'],
            ['conspire', 'conspir'],
            ['conspired', 'conspir'],
            ['conspiring', 'conspir'],
            ['constable', 'constabl'],
            ['constables', 'constabl'],
            ['constance', 'constanc'],
            ['constancy', 'constanc'],
            ['constant', 'constant'],
            ['knack', 'knack'],
            ['knackeries', 'knackeri'],
            ['knacks', 'knack'],
            ['knag', 'knag'],
            ['knave', 'knave'],
            ['knaves', 'knave'],
            ['knavish', 'knavish'],
            ['kneaded', 'knead'],
            ['kneading', 'knead'],
            ['knee', 'knee'],
            ['kneel', 'kneel'],
            ['kneeled', 'kneel'],
            ['kneeling', 'kneel'],
            ['kneels', 'kneel'],
            ['knees', 'knee'],
            ['knell', 'knell'],
            ['knelt', 'knelt'],
            ['knew', 'knew'],
            ['knick', 'knick'],
            ['knif', 'knif'],
            ['knife', 'knife'],
            ['knight', 'knight'],
            ['knightly', 'knight'],
            ['knights', 'knight'],
            ['knit', 'knit'],
            ['knits', 'knit'],
            ['knitted', 'knit'],
            ['knitting', 'knit'],
            ['knives', 'knive'],
            ['knob', 'knob'],
            ['knobs', 'knob'],
            ['knock', 'knock'],
            ['knocked', 'knock'],
            ['knocker', 'knocker'],
            ['knockers', 'knocker'],
            ['knocking', 'knock'],
            ['knocks', 'knock'],
            ['knopp', 'knopp'],
            ['knot', 'knot'],
            ['knots', 'knot'],
            ['freely', 'freeli'],
            ['writings', 'write'],
            ['yore', 'yore'],
            ['yokes', 'yoke'],
            ['vehemently', 'vehement'],
            ['generously', 'generous'],
            ['fluently', 'fluentli'],
        ];
    }

    /**
     * @group        stemmer-vocabulary
     * @dataProvider vocabulary
     * @test
     */
    public function worksCorrectly($input, $expected): void
    {
        $stemmed = (new Stemmer())->stem($input);

        $this->assertEquals($expected, $stemmed);
    }

    public function vocabulary(): array
    {
        $vocabulary = [];

        $handle = fopen(__DIR__ . '/../../../../data/porter2-stemmer-vocabulary.txt', 'r');

        while (false !== ($line = fgets($handle))) {
            $vocabulary[] = explode('=', trim($line));
        }

        fclose($handle);

        return $vocabulary;
    }
}
