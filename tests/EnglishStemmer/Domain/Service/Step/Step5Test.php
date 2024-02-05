<?php

declare(strict_types=1);

namespace Tests\EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Step\Step5;
use EnglishStemmer\Domain\Service\Word;
use PHPUnit\Framework\TestCase;

class Step5Test extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replacesEndings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step5())->__invoke(new Word($input))->word(),
        );
    }

    public function endings(): array
    {
        return [
            ['boroughbridgeeme', 'boroughbridgeem'],
            ['boroughbridgell', 'boroughbridgel'],
        ];
    }
}
