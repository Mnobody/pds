<?php

declare(strict_types=1);

namespace App\Tests\Normalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use App\Normalizer\Normalizer\HyperlinkEraser;

class HyperlinkEraserTest extends TestCase
{
    /**
     * @dataProvider strings
     * @test
     */
    public function removes_hyperlinks(string $input, string $expected): void
    {
        $this->assertEquals(
            $expected,
            (new HyperlinkEraser)->normalize($input)
        );
    }

    public function strings(): array
    {
        return [
            ['www.google.com', ''],
            ['www.google following text', ' following text'],
            ['beginning www.google.com following', 'beginning  following'],

            ['https://www.google.com/', ''],

            ['http://google.com', ''],

            ['ftp://user:password@host:port/path', ''],

            ['file:///home/user/Pictures/example.png', ''],
        ];
    }
}
