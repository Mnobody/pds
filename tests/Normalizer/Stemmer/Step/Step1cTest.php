<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Step\Step1c;

class Step1cTest extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replaces_endings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step1c)->__invoke(new Word($input))->word()
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
