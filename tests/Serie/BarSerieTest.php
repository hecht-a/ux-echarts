<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Serie;

use HechtA\UX\ECharts\Serie\BarSerie;
use PHPUnit\Framework\TestCase;

class BarSerieTest extends TestCase
{
    public function testTypeIsBar(): void
    {
        $this->assertSame('bar', BarSerie::new()->toArray()['type']);
    }

    public function testStaticConstructorWithName(): void
    {
        $this->assertSame('Sales', BarSerie::new('Sales')->toArray()['name']);
    }

    public function testStack(): void
    {
        $this->assertSame('Total', BarSerie::new()->stack('Total')->toArray()['stack']);
    }

    public function testBarWidth(): void
    {
        $this->assertSame('60%', BarSerie::new()->barWidth('60%')->toArray()['barWidth']);
    }

    public function testBarWidthAsInt(): void
    {
        $this->assertSame(30, BarSerie::new()->barWidth(30)->toArray()['barWidth']);
    }

    public function testBarMaxWidth(): void
    {
        $this->assertSame('80%', BarSerie::new()->barMaxWidth('80%')->toArray()['barMaxWidth']);
    }
}
