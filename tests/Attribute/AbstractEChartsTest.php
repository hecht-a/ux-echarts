<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Chart;

use HechtA\UX\ECharts\Attribute\AsEChart;
use HechtA\UX\ECharts\Builder\EChartsBuilder;
use HechtA\UX\ECharts\Model\ECharts;
use HechtA\UX\ECharts\Tests\Fixtures\SpyChart;
use HechtA\UX\ECharts\Tests\Fixtures\TestChart;
use PHPUnit\Framework\TestCase;

class AbstractEChartsTest extends TestCase
{
    private EChartsBuilder $builder;

    protected function setUp(): void
    {
        $this->builder = new EChartsBuilder();
    }

    public function testGetReturnsEChartsInstance(): void
    {
        $chart = new TestChart($this->builder);

        $this->assertInstanceOf(ECharts::class, $chart->get());
    }

    public function testGetAppliesConfiguration(): void
    {
        $chart = new TestChart($this->builder);
        $echarts = $chart->get();

        $this->assertSame(300, $echarts->getHeight());
        $this->assertCount(1, $echarts->getSeries());
    }

    public function testGetReturnsSameInstanceOnSubsequentCalls(): void
    {
        $chart = new TestChart($this->builder);

        $this->assertSame($chart->get(), $chart->get());
    }

    public function testConfigureIsCalledOnlyOnce(): void
    {
        $chart = new SpyChart($this->builder);

        $chart->get();
        $chart->get();
        $chart->get();

        $this->assertSame(1, $chart->configureCalls);
    }

    public function testFixtureHasAsEChartAttribute(): void
    {
        $reflection = new \ReflectionClass(TestChart::class);
        $attributes = $reflection->getAttributes(AsEChart::class);

        $this->assertCount(1, $attributes);
        $this->assertSame('test_chart', $attributes[0]->newInstance()->id);
    }
}
