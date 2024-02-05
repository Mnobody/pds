<?php

declare(strict_types=1);

namespace Tests\EnglishStemmer\Domain\Service\Step;

use EnglishStemmer\Domain\Service\Step\Step1a;
use EnglishStemmer\Domain\Service\Word;
use PHPUnit\Framework\TestCase;

class Step1aTest extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replacesAndCutsOffEndings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step1a())->__invoke(new Word($input))->word(),
        );
    }

    public function endings(): array
    {
        return [
            ['baronesses', 'baroness'],
            ['ties', 'tie'],
            ['cries', 'cri'],
            ['beauteous', 'beauteous'],
            ['cheerless', 'cheerless'],
            ['gas', 'gas'],
            ['this', 'this'],
            ['gaps', 'gap'],
            ['kiwis', 'kiwi'],
        ];
    }
}
