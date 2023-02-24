<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Step\Step0;

class Step0Test extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function cuts_off_endings(string $input): void
    {
        $this->assertEquals(
            '',
            (new Step0)->__invoke(new Word($input))->word()
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
