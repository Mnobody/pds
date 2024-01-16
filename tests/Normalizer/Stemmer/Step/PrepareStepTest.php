<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Step\PrepareStep;
use App\Normalizer\Stemmer\Word;
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
