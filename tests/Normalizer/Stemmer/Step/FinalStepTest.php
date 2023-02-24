<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Step\FinalStep;

class FinalStepTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function casts_to_lowercase(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new FinalStep)->__invoke(new Word($input))->word()
        );
    }

    public function strings(): array
    {
        return [
            ['Youth', 'youth'],
            ['boY', 'boy'],
            ['boYish', 'boyish'],
            ['boYish', 'boyish'],
            ['LOWERCASE', 'lowercase'],
        ];
    }
}
