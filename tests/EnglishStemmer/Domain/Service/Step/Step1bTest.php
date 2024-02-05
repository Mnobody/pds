<?php

declare(strict_types=1);

namespace Tests\EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Step\Step1b;
use EnglishStemmer\Domain\Service\Word;
use PHPUnit\Framework\TestCase;

class Step1bTest extends TestCase
{
    /**
     * @dataProvider exceptions
     * @test
     */
    public function recognizesExceptions(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step1b())->__invoke(new Word($input))->word(),
        );
    }

    public function exceptions(): array
    {
        return [
            ['inning', 'inning'],
            ['outing', 'outing'],
            ['canning', 'canning'],
            ['herring', 'herring'],
            ['earring', 'earring'],
            ['proceed', 'proceed'],
            ['exceed', 'exceed'],
            ['succeed', 'succeed'],
        ];
    }

    /**
     * @dataProvider endings
     * @test
     */
    public function replacesEndings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step1b())->__invoke(new Word($input))->word(),
        );
    }

    public function endings(): array
    {
        return [
            ['agreed', 'agree'],
            ['agreedly', 'agree'],
            ['luxuriated', 'luxuriate'],
            ['hopping', 'hop'],
            ['hoped', 'hope'],
        ];
    }
}
