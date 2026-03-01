<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Option;

use HechtA\UX\ECharts\Option\YAxis;
use PHPUnit\Framework\TestCase;

class YAxisTest extends TestCase
{
    public function testDefaultTypeIsValue(): void
    {
        $this->assertSame('value', (new YAxis())->toArray()['type']);
    }

    public function testConstructorSetsType(): void
    {
        $this->assertSame('log', (new YAxis('log'))->toArray()['type']);
    }

    public function testType(): void
    {
        $this->assertSame('category', (new YAxis())->type('category')->toArray()['type']);
    }

    public function testName(): void
    {
        $this->assertSame('Amount', (new YAxis())->name('Amount')->toArray()['name']);
    }

    public function testMin(): void
    {
        $this->assertSame(0, (new YAxis())->min(0)->toArray()['min']);
    }

    public function testMax(): void
    {
        $this->assertSame(100.5, (new YAxis())->max(100.5)->toArray()['max']);
    }
}
