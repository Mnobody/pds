<?php

declare(strict_types=1);

namespace Tests\EnglishSentenceSplitter\Domain\Service;

use EnglishSentenceSplitter\Domain\Service\FakeDotsMarker;
use EnglishSentenceSplitter\Domain\Service\SentenceBreaker;
use PHPUnit\Framework\TestCase;

final class SentenceBreakerTest extends TestCase
{
    /**
     * @dataProvider sentences
     * @test
     */
    public function correctlyBreaksSentences(string $input, array $expected): void
    {
        $this->assertEquals(
            $expected,
            (new SentenceBreaker(new FakeDotsMarker()))->break($input),
        );
    }

    public function sentences(): array
    {
        return [
            ['Sentence one. Sentence two.', ['Sentence one', 'Sentence two']],
            ['Sentence first! Sentence second? Sentence third.', ['Sentence first', 'Sentence second', 'Sentence third']],
            [
                'Lorem Ipsum Dec. 1 is simply dummy text of the printing industry. Lorem Ipsum Vol. 3 pp. 42-43. Lorem Ipsum Mt. n.d.?',
                ['Lorem Ipsum Dec. 1 is simply dummy text of the printing industry', 'Lorem Ipsum Vol. 3 pp. 42-43', 'Lorem Ipsum Mt. n.d.'],
            ],
        ];
    }
}
