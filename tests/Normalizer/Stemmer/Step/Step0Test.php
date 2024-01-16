<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use App\Normalizer\Stemmer\Step\Step0;
use App\Normalizer\Stemmer\Word;
use PHPUnit\Framework\TestCase;

class Step0Test extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function cutsOffEndings(string $input): void
    {
        $this->assertEquals(
            '',
            (new Step0())->__invoke(new Word($input))->word(),
        );
    }

    public function endings(): array
    {
        return [
            ['\''],
            ['\'s'],
            ['\'s\''],
        ];
    }
}
