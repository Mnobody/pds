<?php

declare(strict_types=1);

namespace App\Inspector;

use App\Shared\Letter\Cyrillic;

final class CyrillicInspector
{
    private const TEMPLATE = '<b>%s</b>';

    private const EMPTY_HIGHLIGHTED_TEXT = '';

    public function check(string $string): CyrillicInspection
    {
        $count = preg_match_all($this->pattern(), $string);

        $highlighted = $count
            ? $this->highlight($string)
            : self::EMPTY_HIGHLIGHTED_TEXT;

        return new CyrillicInspection($count, $highlighted);
    }

    private function highlight($string): string
    {
        return preg_replace_callback(
            $this->pattern(),
            function ($matches) {

                list($complete, $first) = $matches;

                if ($first !== $complete) {
                    throw new \InvalidArgumentException(sprintf('Wrong regex pattern. "%s" expects to be equal to "%s".', $first, $complete));
                }

                return sprintf(self::TEMPLATE, htmlspecialchars($first));
            },
            $string
        );
    }

    public function pattern(): string
    {
        return sprintf('/([%s])/u', implode(Cyrillic::LETTERS));
    }
}
