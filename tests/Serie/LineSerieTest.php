<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Serie;

use HechtA\UX\ECharts\Serie\LineSerie;
use PHPUnit\Framework\TestCase;

class LineSerieTest extends TestCase
{
    public function testTypeIsLine(): void
    {
        $this->assertSame('line', LineSerie::new()->toArray()['type']);
    }

    public function testStaticConstructorWithName(): void
    {
        $this->assertSame('Revenue', LineSerie::new('Revenue')->toArray()['name']);
    }

    public function testSmooth(): void
    {
        $this->assertTrue(LineSerie::new()->smooth()->toArray()['smooth']);
    }

    public function testSmoothFalse(): void
    {
        $this->assertFalse(LineSerie::new()->smooth(false)->toArray()['smooth']);
    }

    public function testStack(): void
    {
        $this->assertSame('Total', LineSerie::new()->stack('Total')->toArray()['stack']);
    }

    public function testAreaStyle(): void
    {
        $this->assertArrayHasKey('areaStyle', LineSerie::new()->areaStyle()->toArray());
    }

    public function testStep(): void
    {
        $this->assertSame('start', LineSerie::new()->step('start')->toArray()['step']);
    }

    public function testFullChain(): void
    {
        $serie = LineSerie::new('Email')
            ->data([120, 132, 101])
            ->smooth()
            ->stack('Total');

        $array = $serie->toArray();
        $this->assertSame('line', $array['type']);
        $this->assertSame('Email', $array['name']);
        $this->assertSame([120, 132, 101], $array['data']);
        $this->assertTrue($array['smooth']);
        $this->assertSame('Total', $array['stack']);
    }
}
