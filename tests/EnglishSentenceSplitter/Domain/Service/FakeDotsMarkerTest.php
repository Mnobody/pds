<?php

declare(strict_types=1);

namespace Tests\EnglishSentenceSplitter\Domain\Service;

use EnglishSentenceSplitter\Domain\Service\FakeDotsMarker;
use PHPUnit\Framework\TestCase;

final class FakeDotsMarkerTest extends TestCase
{
    /**
     * @dataProvider replacements
     * @test
     */
    public function correctlyReplacesDotsWithMark(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new FakeDotsMarker())->mark($input),
        );
    }

    /**
     * @dataProvider recoupments
     * @test
     */
    public function correctlyRestoresMarkedDots(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new FakeDotsMarker())->restore($input),
        );
    }

    public function replacements(): array
    {
        return [
            ['U.S.', 'U\#S\#'],
            ['U. S.', 'U\# S\#'],

            ['U.N.', 'U\#N\#'],
            ['U. N.', 'U\# N\#'],

            ['D.C.', 'D\#C\#'],
            ['D. C.', 'D\# C\#'],

            ['B.C.', 'B\#C\#'],
            ['B. C.', 'B\# C\#'],

            ['A.D.', 'A\#D\#'],
            ['A. D.', 'A\# D\#'],

            ['Mt.', 'Mt\#'],
            ['St.', 'St\#'],

            ['Dr.', 'Dr\#'],
            ['Mr.', 'Mr\#'],
            ['Ms.', 'Ms\#'],
            ['Mrs.', 'Mrs\#'],
            ['Rev.', 'Rev\#'],

            ['vs.', 'vs\#'],
            ['viz.', 'viz\#'],
            ['etc.', 'etc\#'],

            ['Inc.', 'Inc\#'],
            ['Ltd.', 'Ltd\#'],

            ['et.al.', 'et\#al\#'],
            ['et. al.', 'et\# al\#'],

            ['e.g.', 'e\#g\#'],
            ['e. g.', 'e\# g\#'],

            ['i.e.', 'i\#e\#'],
            ['i. e.', 'i\# e\#'],

            ['n.p', 'n\#p'],
            ['n. p', 'n\# p'],

            ['n.d.', 'n\#d\#'],
            ['n. d.', 'n\# d\#'],

            ['p.42', 'p\#42'],
            ['p. 42', 'p\# 42'],
            ['p.  42', 'p\#  42'],

            ['pp.42-52', 'pp\#42-52'],
            ['pp. 42-52', 'pp\# 42-52'],
            ['pp.  42-52', 'pp\#  42-52'],

            ['No.42', 'No\#42'],
            ['No. 42', 'No\# 42'],
            ['No.  42', 'No\#  42'],
            ['no.42', 'no\#42'],
            ['no. 42', 'no\# 42'],
            ['no.  42', 'no\#  42'],

            ['Vol.42', 'Vol\#42'],
            ['Vol. 42', 'Vol\# 42'],
            ['Vol.  42', 'Vol\#  42'],
            ['vol.42', 'vol\#42'],
            ['vol. 42', 'vol\# 42'],
            ['vol.  42', 'vol\#  42'],

            ['Jan.', 'Jan\#'],
            ['Feb.', 'Feb\#'],
            ['Mar.', 'Mar\#'],
            ['Apr.', 'Apr\#'],
            ['May.', 'May\#'],
            ['Jun.', 'Jun\#'],
            ['Jul.', 'Jul\#'],
            ['Aug.', 'Aug\#'],
            ['Sep.', 'Sep\#'],
            ['Sept.', 'Sept\#'],
            ['Oct.', 'Oct\#'],
            ['Nov.', 'Nov\#'],
            ['Dec.', 'Dec\#'],
        ];
    }

    public function recoupments(): array
    {
        return array_map(
            static fn (array $pair) => [$pair[1], $pair[0]],
            $this->replacements(),
        );
    }
}
