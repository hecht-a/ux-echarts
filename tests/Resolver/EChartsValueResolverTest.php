<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Resolver;

use HechtA\UX\ECharts\Builder\EChartsBuilder;
use HechtA\UX\ECharts\Chart\EchartsInterface;
use HechtA\UX\ECharts\Registry\EChartsRegistry;
use HechtA\UX\ECharts\Resolver\EChartsValueResolver;
use HechtA\UX\ECharts\Tests\Fixtures\RevenueChart;
use HechtA\UX\ECharts\Tests\Fixtures\SalesChart;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class EChartsValueResolverTest extends TestCase
{
    private EChartsRegistry $registry;
    private EChartsValueResolver $resolver;
    private EChartsBuilder $builder;

    protected function setUp(): void
    {
        $this->builder = new EChartsBuilder();
        $this->registry = new EChartsRegistry();
        $this->resolver = new EChartsValueResolver($this->registry);
    }

    private function argument(?string $type): ArgumentMetadata
    {
        return new ArgumentMetadata('chart', $type, false, false, null);
    }

    public function testResolvesRegisteredChart(): void
    {
        $chart = new SalesChart($this->builder);
        $this->registry->add('sales', $chart);

        $result = iterator_to_array($this->resolver->resolve(new Request(), $this->argument(SalesChart::class)));

        $this->assertCount(1, $result);
        $this->assertSame($chart, $result[0]);
    }

    public function testResolvesCorrectChartAmongMultiple(): void
    {
        $sales = new SalesChart($this->builder);
        $revenue = new RevenueChart($this->builder);
        $this->registry->add('sales', $sales);
        $this->registry->add('revenue', $revenue);

        $result = iterator_to_array($this->resolver->resolve(new Request(), $this->argument(RevenueChart::class)));

        $this->assertCount(1, $result);
        $this->assertSame($revenue, $result[0]);
    }

    public function testReturnsEmptyWhenTypeIsNull(): void
    {
        $result = iterator_to_array($this->resolver->resolve(new Request(), $this->argument(null)));

        $this->assertEmpty($result);
    }

    public function testReturnsEmptyWhenTypeIsNotEChartInterface(): void
    {
        $result = iterator_to_array($this->resolver->resolve(new Request(), $this->argument(\stdClass::class)));

        $this->assertEmpty($result);
    }

    public function testReturnsEmptyWhenTypeIsNotAClass(): void
    {
        $result = iterator_to_array($this->resolver->resolve(new Request(), $this->argument('string')));

        $this->assertEmpty($result);
    }

    public function testReturnsEmptyWhenChartNotInRegistry(): void
    {
        $result = iterator_to_array($this->resolver->resolve(new Request(), $this->argument(SalesChart::class)));

        $this->assertEmpty($result);
    }

    public function testReturnsEmptyWhenTypeIsEChartInterfaceItself(): void
    {
        $result = iterator_to_array($this->resolver->resolve(new Request(), $this->argument(EchartsInterface::class)));

        $this->assertEmpty($result);
    }
}
