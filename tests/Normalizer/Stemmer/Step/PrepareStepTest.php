<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Step\PrepareStep;

class PrepareStepTest extends TestCase
{
    /**
     * @dataProvider words
     * @test
     */
    public function prepares_word(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new PrepareStep)->__invoke(new Word($input))->word()
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
