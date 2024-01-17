<?php

declare(strict_types=1);

namespace App\Boundary;

final class SentenceBreaker
{
    private const SPLIT_PATTERN = '/[.?!]( +)?/';

    public function __construct(private readonly FakeDotsMarker $marker)
    {
    }

    public function break(string $text): array
    {
        return array_map(
            fn (string $sentence) => $this->marker->restore($sentence),
            preg_split(
                self::SPLIT_PATTERN,
                $this->marker->mark($text),
                -1,
                PREG_SPLIT_NO_EMPTY,
            ),
        );
    }
}
