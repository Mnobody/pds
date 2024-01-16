<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Step\Step1a;
use App\Normalizer\Stemmer\Word;
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
