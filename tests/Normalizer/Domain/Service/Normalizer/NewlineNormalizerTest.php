<?php

declare(strict_types=1);

namespace Tests\Normalizer\Domain\Service\Normalizer;

use Normalizer\Domain\Service\Normalizer\NewlineNormalizer;
use PHPUnit\Framework\TestCase;

class NewlineNormalizerTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function replacesMultipleNewlineCharactersWithSingleOne(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new NewlineNormalizer())->normalize($input),
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
