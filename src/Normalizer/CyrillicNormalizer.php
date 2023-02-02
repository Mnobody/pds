<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Shared\Letter\Latin;
use App\Shared\Letter\Cyrillic;
use App\Normalizer\Exception\LetterIsNotSupportedException;

final class CyrillicNormalizer
{
    public function normalize(string $string): string
    {
        $result = $string;

        foreach (Cyrillic::LETTERS as $cyrillic) {
            $result = str_replace(
                $cyrillic,
                $this->replacement($cyrillic),
                $result
            );
        }

        return $result;
    }

    private function replacement(string $cyrillic): string
    {
        return match ($cyrillic) {
            Cyrillic::LOWERCASE_A => Latin::LOWERCASE_A,
            Cyrillic::LOWERCASE_E => Latin::LOWERCASE_E,
            Cyrillic::LOWERCASE_O => Latin::LOWERCASE_O,
            Cyrillic::LOWERCASE_R => Latin::LOWERCASE_P,
            Cyrillic::LOWERCASE_S => Latin::LOWERCASE_C,
            Cyrillic::LOWERCASE_U => Latin::LOWERCASE_Y,
            Cyrillic::LOWERCASE_H => Latin::LOWERCASE_X,
            Cyrillic::LOWERCASE_I => Latin::LOWERCASE_I,
            Cyrillic::UPPERCASE_A => Latin::UPPERCASE_A,
            Cyrillic::UPPERCASE_V => Latin::UPPERCASE_B,
            Cyrillic::UPPERCASE_E => Latin::UPPERCASE_E,
            Cyrillic::UPPERCASE_O => Latin::UPPERCASE_O,
            Cyrillic::UPPERCASE_R => Latin::UPPERCASE_P,
            Cyrillic::UPPERCASE_S => Latin::UPPERCASE_C,
            Cyrillic::UPPERCASE_T => Latin::UPPERCASE_T,
            Cyrillic::UPPERCASE_U => Latin::UPPERCASE_Y,
            Cyrillic::UPPERCASE_H => Latin::UPPERCASE_X,
            Cyrillic::UPPERCASE_I => Latin::UPPERCASE_I,
            Cyrillic::UPPERCASE_K => Latin::UPPERCASE_K,
            Cyrillic::UPPERCASE_M => Latin::UPPERCASE_M,
            Cyrillic::UPPERCASE_N => Latin::UPPERCASE_H,
            default => throw new LetterIsNotSupportedException(sprintf('Letter "%s" is not supported.', $cyrillic)),
        };
    }

}