<?php

declare(strict_types=1);

namespace Tests\Normalizer\Domain\Service\Normalizer;

use Normalizer\Domain\Service\Normalizer\SingleQuoteMarkNormalizer;
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
