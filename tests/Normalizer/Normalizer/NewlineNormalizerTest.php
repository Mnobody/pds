<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Normalizer\NewlineNormalizer;

class NewlineNormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function replaces_multiple_newline_characters_with_single_one(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new NewlineNormalizer)->normalize($input)
        );
    }

    public function strings(): array
    {
        return [
            ["\n", "\n"],
            ["\n\n", "\n"],
            ["\n\n\n", "\n"],
            ["line \n", "line \n"],
            ["line\n", "line\n"],
        ];
    }
}
