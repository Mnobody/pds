<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Step\Step3;

class Step3Test extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replaces_endings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step3)->__invoke(new Word($input))->word()
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
