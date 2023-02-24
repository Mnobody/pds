<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Stemmer\Step;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Stemmer\Word;
use App\Normalizer\Stemmer\Step\Step2;

class Step2Test extends TestCase
{
    /**
     * @dataProvider endings
     * @test
     */
    public function replaces_endings(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new Step2)->__invoke(new Word($input))->word()
        );
    }

    public function endings(): array
    {
        return [
            ['sometional', 'sometion'],
            ['someenci', 'someence'],
            ['someanci', 'someance'],
            ['someabli', 'someable'],
            ['someentli', 'someent'],
            ['someizer', 'someize'],
            ['someization', 'someize'],
            ['someational', 'someate'],
            ['someation', 'someate'],
            ['someator', 'someate'],
            ['somealism', 'someal'],
            ['somealiti', 'someal'],
            ['somealli', 'someal'],
            ['somefulness', 'someful'],
            ['someousli', 'someous'],
            ['someousness', 'someous'],
            ['someiveness', 'someive'],
            ['someiviti', 'someive'],
            ['somebiliti', 'someble'],
            ['somebli', 'someble'],
            ['somefulli', 'someful'],
            ['somelessli', 'someless'],

            ['somehli', 'someh'],

            ['somelogi', 'somelog'],
        ];
    }
}
