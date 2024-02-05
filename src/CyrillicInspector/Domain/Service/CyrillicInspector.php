<?php

declare(strict_types=1);

namespace CyrillicInspector\Domain\Service;

use InvalidArgumentException;
use Shared\Domain\ValueObject\Cyrillic;

final class CyrillicInspector
{
    private const TEMPLATE = '<b>%s</b>';

    private const EMPTY_HIGHLIGHTED_TEXT = '';

    public function __construct(private readonly Cyrillic $cyrillic)
    {
    }

    public function check(string $string): CyrillicInspection
    {
        $count = preg_match_all($this->pattern(), $string);

        $highlighted = true === $count > 0
            ? $this->highlight($string)
            : self::EMPTY_HIGHLIGHTED_TEXT;

        return new CyrillicInspection($count, $highlighted);
    }

    public function pattern(): string
    {
        return sprintf('/([%s])/u', implode($this->cyrillic->letters()));
    }

    private function highlight(string $string): string
    {
        return preg_replace_callback(
            $this->pattern(),
            static function ($matches) {

                list($complete, $first) = $matches;

                if ($first !== $complete) {
                    throw new InvalidArgumentException(
                        sprintf('Wrong regex pattern. "%s" expects to be equal to "%s".', $first, $complete),
                    );
                }

                return sprintf(self::TEMPLATE, htmlspecialchars($first));
            },
            $string,
        );
    }
}
