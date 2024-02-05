<?php

declare(strict_types=1);

namespace CyrillicNormalizer\Domain\Service;

use Shared\Domain\ValueObject\Cyrillic;

final class CyrillicNormalizer
{
    public function __construct(
        private readonly Cyrillic $cyrillic,
        private readonly CyrillicToLatinMapper $mapper,
    ) {
    }

    public function normalize(string $string): string
    {
        $result = $string;

        foreach ($this->cyrillic->letters() as $cyrillic) {
            $result = str_replace(
                $cyrillic,
                $this->mapper->replacement($cyrillic),
                $result,
            );
        }

        return $result;
    }
}
