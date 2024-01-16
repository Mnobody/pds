<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use App\Normalizer\Normalizer\SingleQuoteMarkNormalizer;
use PHPUnit\Framework\TestCase;

class SingleQuoteMarkNormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function replacesUnicodeSingleQuoteMarksWithSimpleOne(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new SingleQuoteMarkNormalizer())->normalize($input),
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
