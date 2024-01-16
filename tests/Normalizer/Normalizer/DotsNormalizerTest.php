<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use App\Normalizer\Normalizer\DotsNormalizer;
use PHPUnit\Framework\TestCase;

class DotsNormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function replacesUnicodeDotsWithDots(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new DotsNormalizer())->normalize($input),
        );
    }

    public function strings(): array
    {
        return [
            ['something…', 'something...'],
            ['…', '...'],
        ];
    }
}
