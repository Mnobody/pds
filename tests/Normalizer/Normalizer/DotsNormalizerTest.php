<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Normalizer\DotsNormalizer;

class DotsNormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function replaces_unicode_dots_with_dots(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new DotsNormalizer)->normalize($input)
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
