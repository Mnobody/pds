<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Step\Step5;

class Step5Test extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replaces_endings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step5)->__invoke(new Word($input))->word()
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
