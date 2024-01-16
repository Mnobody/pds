<?php

declare(strict_types=1);

namespace App\Shared\Letter;

final class Cyrillic
{
    public const LOWERCASE_A = 'а';
    public const LOWERCASE_E = 'е';
    public const LOWERCASE_O = 'о';
    public const LOWERCASE_R = 'р';
    public const LOWERCASE_S = 'с';
    public const LOWERCASE_U = 'у';
    public const LOWERCASE_H = 'х';
    public const LOWERCASE_I = 'і';

    public const UPPERCASE_A = 'А';
    public const UPPERCASE_V = 'В';
    public const UPPERCASE_E = 'Е';
    public const UPPERCASE_O = 'О';
    public const UPPERCASE_R = 'Р';
    public const UPPERCASE_S = 'С';
    public const UPPERCASE_T = 'Т';
    public const UPPERCASE_U = 'У';
    public const UPPERCASE_H = 'Х';
    public const UPPERCASE_I = 'І';
    public const UPPERCASE_K = 'К';
    public const UPPERCASE_M = 'М';
    public const UPPERCASE_N = 'Н';

    public function letters(): array
    {
        return [
            self::LOWERCASE_A, self::LOWERCASE_E, self::LOWERCASE_O,
            self::LOWERCASE_R, self::LOWERCASE_S, self::LOWERCASE_U,
            self::LOWERCASE_H, self::LOWERCASE_I,
            self::UPPERCASE_A, self::UPPERCASE_V, self::UPPERCASE_E,
            self::UPPERCASE_O, self::UPPERCASE_R, self::UPPERCASE_S,
            self::UPPERCASE_T, self::UPPERCASE_U, self::UPPERCASE_H,
            self::UPPERCASE_I, self::UPPERCASE_K, self::UPPERCASE_M,
            self::UPPERCASE_N,
        ];
    }
}
