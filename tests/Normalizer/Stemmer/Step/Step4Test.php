<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Step\Step4;
use App\Normalizer\Stemmer\Word;
use PHPUnit\Framework\TestCase;

class Step4Test extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replacesEndings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step4())->__invoke(new Word($input))->word(),
        );
    }

    public function endings(): array
    {
        return [
            ['boroughbridgeement', 'boroughbridge'],
            ['boroughbridgeance', 'boroughbridge'],
            ['boroughbridgeence', 'boroughbridge'],
            ['boroughbridgeable', 'boroughbridge'],
            ['boroughbridgeible', 'boroughbridge'],
            ['boroughbridgment', 'boroughbridg'],
            ['boroughbridgeant', 'boroughbridge'],
            ['boroughbridgeent', 'boroughbridge'],
            ['boroughbridgeism', 'boroughbridge'],
            ['boroughbridgeate', 'boroughbridge'],
            ['boroughbridgeiti', 'boroughbridge'],
            ['boroughbridgeous', 'boroughbridge'],
            ['boroughbridgeive', 'boroughbridge'],
            ['boroughbridgeize', 'boroughbridge'],
            ['boroughbridgeer', 'boroughbridge'],
            ['boroughbridgeal', 'boroughbridge'],
            ['boroughbridgeic', 'boroughbridge'],

            ['boroughbridgesion', 'boroughbridges'],
            ['boroughbridgetion', 'boroughbridget'],
        ];
    }
}
