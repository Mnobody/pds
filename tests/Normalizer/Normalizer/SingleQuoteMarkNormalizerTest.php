<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Normalizer\SingleQuoteMarkNormalizer;

class SingleQuoteMarkNormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function replaces_unicode_single_quote_marks_with_simple_one(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new SingleQuoteMarkNormalizer)->normalize($input)
        );
    }

    public function strings(): array
    {
        return [
            ['he\'s', 'he\'s'],
            ['he‘s', 'he\'s'],
            ['he’s', 'he\'s'],
            ['he‛s', 'he\'s'],
            ['he‚s', 'he\'s'],
            ['he`s', 'he\'s'],
            ['he``s', 'he\'\'s'],
            ['he```s', 'he\'\'\'s'],
            ['he‘’‛‚`s', 'he\'\'\'\'\'s'],
        ];
    }
}
