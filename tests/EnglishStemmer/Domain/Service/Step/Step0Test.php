<?php

declare(strict_types=1);

namespace Tests\EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Step\Step0;
use EnglishStemmer\Domain\Service\Word;
use PHPUnit\Framework\TestCase;

class Step0Test extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function cutsOffEndings(string $input): void
    {
        $this->assertEquals(
            '',
            (new Step0())->__invoke(new Word($input))->word(),
        );
    }

    public function endings(): array
    {
        return [
            ['\''],
            ['\'s'],
            ['\'s\''],
        ];
    }
}
