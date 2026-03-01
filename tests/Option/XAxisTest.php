<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Option;

use HechtA\UX\ECharts\Option\XAxis;
use PHPUnit\Framework\TestCase;

class XAxisTest extends TestCase
{
    public function testDefaultTypeIsCategory(): void
    {
        $this->assertSame('category', (new XAxis())->toArray()['type']);
    }

    public function testConstructorWithData(): void
    {
        $xAxis = new XAxis(data: ['Mon', 'Tue', 'Wed']);
        $this->assertSame(['Mon', 'Tue', 'Wed'], $xAxis->toArray()['data']);
    }

    public function testEmptyDataIsNotIncluded(): void
    {
        $this->assertArrayNotHasKey('data', (new XAxis())->toArray());
    }

    public function testType(): void
    {
        $this->assertSame('time', (new XAxis())->type('time')->toArray()['type']);
    }

    public function testData(): void
    {
        $xAxis = (new XAxis())->data(['A', 'B']);
        $this->assertSame(['A', 'B'], $xAxis->toArray()['data']);
    }

    public function testName(): void
    {
        $this->assertSame('Week', (new XAxis())->name('Week')->toArray()['name']);
    }

    public function testBoundaryGap(): void
    {
        $this->assertFalse((new XAxis())->boundaryGap(false)->toArray()['boundaryGap']);
    }
}
