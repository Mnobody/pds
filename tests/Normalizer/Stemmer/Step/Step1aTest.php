<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Step\Step1a;

class Step1aTest extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replaces_and_cuts_off_endings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step1a)->__invoke(new Word($input))->word()
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
