<?php

declare(strict_types=1);

namespace Tests\Normalizer\Domain\Service;

use Normalizer\Domain\Service\Normalizer;
use PHPUnit\Framework\TestCase;

class NormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function correctlyNormalizes(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Normalizer())->normalize($input),
        );
    }

    public function strings(): array
    {
        return [
            ['Some  text    example', 'Some text example'], // WhitespaceNormalizer
            ['Some text example' . "\n\n", 'Some text example' . "\n"], // NewlineNormalizer
            ['Some text example www.google.com', 'Some text example '], // HyperlinkEraser
            ['Some text -- example', 'Some text - example'], // DashNormalizer
            ['Some `another` text example', 'Some \'another\' text example'], // SingleQuoteMarkNormalizer
            ['Some ``another`` text example', 'Some "another" text example'], // DoubleQuoteMarkNormalizer
            ['Some text example…', 'Some text example...'], // DotsNormalizer
            ['Some text examplę', 'Some text exampl'], // NonAsciiEraser
            ['Some text example', 'Some text example'], // UnicodeSymbolsEraser
        ];
    }
}
