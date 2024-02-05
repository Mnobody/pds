<?php

declare(strict_types=1);

namespace Tests\EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Step\FinalStep;
use EnglishStemmer\Domain\Service\Word;
use PHPUnit\Framework\TestCase;

class FinalStepTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function castsToLowercase(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new FinalStep())->__invoke(new Word($input))->word(),
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
