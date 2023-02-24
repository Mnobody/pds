<?php

declare(strict_types=1);

namespace App\Tests\Inspector;

use PHPUnit\Framework\TestCase;
use App\Inspector\CyrillicInspection;

class CyrillicInspectionTest extends TestCase
{
    /**
     * @test
     */
    public function returns_count(): void
    {
        $inspection = new CyrillicInspection(0, '');

        $this->assertEquals(0, $inspection->count());
    }

    /**
     * @test
     */
    public function returns_highlighted(): void
    {
        $inspection = new CyrillicInspection(1, 'some text');

        $this->assertEquals('some text', $inspection->highlighted());
    }

    /**
     * @test
     */
    public function returns_detected_correctly(): void
    {
        $detected1 = (new CyrillicInspection(1, ''))->detected();
        $detected2 = (new CyrillicInspection(42, ''))->detected();
        $notDetected =( new CyrillicInspection(0, ''))->detected();

        $this->assertTrue($detected1);
        $this->assertTrue($detected2);
        $this->assertFalse($notDetected);
    }
}
