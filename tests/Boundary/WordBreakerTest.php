<?php

declare(strict_types=1);

namespace App\Tests\Boundary;

use App\Boundary\WordBreaker;
use PHPUnit\Framework\TestCase;

final class WordBreakerTest extends TestCase
{
    /**
     * @dataProvider words
     * @test
     */
    public function correctlyBreaksWords(string $input, array $expected): void
    {
        $this->assertEquals(
            $expected,
            (new WordBreaker())->break($input),
        );
    }

    public function words(): array
    {
        return [
            ['Some example first sentence', ['Some', 'example', 'first', 'sentence']],
            ['Some second example test spaced text', ['Some', 'second', 'example', 'test', 'spaced', 'text']],
        ];
    }
}
