<?php

declare(strict_types=1);

namespace Tests\EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Step\Step3;
use EnglishStemmer\Domain\Service\Word;
use PHPUnit\Framework\TestCase;

class Step3Test extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replacesEndings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step3())->__invoke(new Word($input))->word(),
        );
    }

    public function endings(): array
    {
        return [
            ['sometional', 'sometion'],

            ['sometional', 'sometion'],
            ['someational', 'someate'],
            ['somealize', 'someal'],

            ['someicate', 'someic'],
            ['someiciti', 'someic'],
            ['someical', 'someic'],

            // deletes
            ['someful', 'some'],
            ['someness','some'],

            ['boroughbridgeative', 'boroughbridge'],
        ];
    }
}
