<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Step\Step1b;

class Step1bTest extends TestCase
{
    /**
     * @dataProvider exceptions
     * @test
     */
    public function recognizes_exceptions(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step1b)->__invoke(new Word($input))->word()
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
    public function replaces_endings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step1b)->__invoke(new Word($input))->word()
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
