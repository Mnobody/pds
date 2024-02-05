<?php

declare(strict_types=1);

namespace Tests\EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Step\Step1c;
use EnglishStemmer\Domain\Service\Word;
use PHPUnit\Framework\TestCase;

class Step1cTest extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replacesEndings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step1c())->__invoke(new Word($input))->word(),
        );
    }

    public function endings(): array
    {
        return [
            ['cry', 'cri'],
            ['crY', 'cri'],
            ['by', 'by'],
            ['say', 'say'],
        ];
    }
}
