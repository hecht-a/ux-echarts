<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Registry;

use HechtA\UX\ECharts\Builder\EChartsBuilder;
use HechtA\UX\ECharts\Chart\EchartsInterface;
use HechtA\UX\ECharts\Exception\InvalidArgumentException;
use HechtA\UX\ECharts\Registry\EChartsRegistry;
use HechtA\UX\ECharts\Tests\Fixtures\ChartA;
use HechtA\UX\ECharts\Tests\Fixtures\ChartB;
use PHPUnit\Framework\TestCase;

class EChartsRegistryTest extends TestCase
{
    private EChartsRegistry $registry;
    private EChartsBuilder $builder;

    protected function setUp(): void
    {
        $this->registry = new EChartsRegistry();
        $this->builder = new EChartsBuilder();
    }

    public function testGetReturnsRegisteredChart(): void
    {
        $chart = new ChartA($this->builder);
        $this->registry->add('chart_a', $chart);

        $this->assertSame($chart, $this->registry->get('chart_a'));
    }

    public function testGetThrowsOnUnknownId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No chart registered with id "unknown"');

        $this->registry->get('unknown');
    }

    public function testGetThrowsWithHelpfulMessage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('#[AsEChart]');

        $this->registry->get('missing');
    }

    public function testHasReturnsTrueForRegisteredId(): void
    {
        $this->registry->add('chart_a', new ChartA($this->builder));

        $this->assertTrue($this->registry->has('chart_a'));
    }

    public function testHasReturnsFalseForUnknownId(): void
    {
        $this->assertFalse($this->registry->has('unknown'));
    }

    public function testAllReturnsEmptyArrayInitially(): void
    {
        $this->assertSame([], $this->registry->all());
    }

    public function testAllReturnsAllRegisteredCharts(): void
    {
        $a = new ChartA($this->builder);
        $b = new ChartB($this->builder);
        $this->registry->add('chart_a', $a);
        $this->registry->add('chart_b', $b);

        $all = $this->registry->all();
        $this->assertCount(2, $all);
        $this->assertSame($a, $all['chart_a']);
        $this->assertSame($b, $all['chart_b']);
    }

    public function testFindByClassReturnsMatchingChart(): void
    {
        $chart = new ChartA($this->builder);
        $this->registry->add('chart_a', $chart);

        $this->assertSame($chart, $this->registry->findByClass(ChartA::class));
    }

    public function testFindByClassReturnsNullWhenNotFound(): void
    {
        $this->registry->add('chart_a', new ChartA($this->builder));

        $this->assertNull($this->registry->findByClass(ChartB::class));
    }

    public function testFindByClassWorksWithInterface(): void
    {
        $chart = new ChartA($this->builder);
        $this->registry->add('chart_a', $chart);

        $this->assertSame($chart, $this->registry->findByClass(EchartsInterface::class));
    }

    public function testAddOverwritesExistingId(): void
    {
        $a = new ChartA($this->builder);
        $b = new ChartB($this->builder);

        $this->registry->add('my_chart', $a);
        $this->registry->add('my_chart', $b);

        $this->assertSame($b, $this->registry->get('my_chart'));
    }
}
