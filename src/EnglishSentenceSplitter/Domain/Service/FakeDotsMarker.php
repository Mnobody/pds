<?php

declare(strict_types=1);

namespace EnglishSentenceSplitter\Domain\Service;

/**
 * Marks dots that are not the end of a sentence
 */
final class FakeDotsMarker
{
    private const DOT  = '.';
    private const MARK = '\#';

    private const CAPTURE = 'capture';

    private const RESTORE_PATTERN = '/(?P<' . self::CAPTURE . '>\\' . self::MARK . ')/';

    private const PATTERNS = [
        '/(?P<' . self::CAPTURE . '>U\.\s*S\.)/', // 'U.S.' or 'U. S.' - United States
        '/(?P<' . self::CAPTURE . '>U\.\s*N\.)/', // 'U.N.' or 'U. N.' - United Nations
        '/(?P<' . self::CAPTURE . '>D\.\s*C\.)/', // 'D.C.' or 'D. C.' - Washington, D.C.
        '/(?P<' . self::CAPTURE . '>B\.\s*C\.)/', // 'B.C.' or 'B. C.' - before Christ
        '/(?P<' . self::CAPTURE . '>A\.\s*D\.)/', // 'A.D.' or 'A. D.' - Anno Domini

        '/(?P<' . self::CAPTURE . '>Mt\.)/', //      'Mt.' - mount or mountain
        '/(?P<' . self::CAPTURE . '>St\.)/', //      'St.' - Saint

        '/(?P<' . self::CAPTURE . '>Dr\.)/', //      'Dr.'
        '/(?P<' . self::CAPTURE . '>Mr\.)/', //      'Mr.'
        '/(?P<' . self::CAPTURE . '>Ms\.)/', //      'Ms.'
        '/(?P<' . self::CAPTURE . '>Mrs\.)/', //     'Mrs.'
        '/(?P<' . self::CAPTURE . '>Rev\.)/', //     'Rev.' - Reverend

        '/(?P<' . self::CAPTURE . '>vs\.)/', //      'vs.' - versus
        '/(?P<' . self::CAPTURE . '>viz\.)/', //     'viz.' - videlicet
        '/(?P<' . self::CAPTURE . '>etc\.)/', //     'etc.' - et cetera
        '/(?P<' . self::CAPTURE . '>Inc\.)/', //     'Inc.' - incorporated
        '/(?P<' . self::CAPTURE . '>Ltd\.)/', //     'Ltd.' - limited

        '/(?P<' . self::CAPTURE . '>et\.\s*al\.)/', // 'et.al.' or 'et. al.' - and others
        '/(?P<' . self::CAPTURE . '>e\.\s*g\.)/', //   'e.g.' or 'e. g.' - for example
        '/(?P<' . self::CAPTURE . '>i\.\s*e\.)/', //   'i.e.' or 'i. e.' - that is, for example

        '/(?P<' . self::CAPTURE . '>n\.\s*p)/', //   'n.p' or 'n. p' - no place of publication
        '/(?P<' . self::CAPTURE . '>n\.\s*d\.)/', // 'n.d.' or 'n. d.' - no publication date
        '/(?P<' . self::CAPTURE . '>p\.\s*\d)/', //  'p. 42' or 'p.  42' - page number (in text citation)
        '/(?P<' . self::CAPTURE . '>pp\.\s*\d)/', //  'p. 42-52' or 'p.  42-52' - pages numbers (in text citation)

        '/(?P<' . self::CAPTURE . '>[Nn]o\.\s*\d)/', //  'No. 42' or 'no.  42' - number
        '/(?P<' . self::CAPTURE . '>[Vv]ol\.\s*\d)/', //  'Vol. 42' or 'vol.  42' - volume
        '/(?P<' . self::CAPTURE . '>((Jan)|(Feb)|(Mar)|(Apr)|(May)|(Jun)|(Jul)|(Aug)|(Sep)|(Sept)|(Oct)|(Nov)|(Dec))\.)/', //  'Feb.'
    ];

    /**
     * Replace dots with '\#' mark in places that are not the end of the sentence
     */
    public function mark(string $text): string
    {
        foreach (self::PATTERNS as $pattern) {
            $text = preg_replace_callback(
                $pattern,
                static fn ($matches) => str_replace(self::DOT, self::MARK, $matches[self::CAPTURE]),
                $text,
            );
        }

        return $text;
    }

    /**
     * Restore marked dots
     */
    public function restore(string $text): string
    {
        return preg_replace_callback(
            self::RESTORE_PATTERN,
            static fn ($matches) => str_replace(self::MARK, self::DOT, $matches[self::CAPTURE]),
            $text,
        );
    }
}
