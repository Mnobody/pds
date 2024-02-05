<?php

declare(strict_types=1);

namespace Tests\EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Step\PrepareStep;
use EnglishStemmer\Domain\Service\Word;
use PHPUnit\Framework\TestCase;

class PrepareStepTest extends TestCase
{
    /**
     * @dataProvider words
     * @test
     */
    public function preparesWord(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new PrepareStep())->__invoke(new Word($input))->word(),
        );
    }

    public function words(): array
    {
        return [
            ['\'is', 'is'],
            ['youth', 'Youth'],
            ['boy', 'boY'],
            ['\'boyish', 'boYish'],
        ];
    }
}
