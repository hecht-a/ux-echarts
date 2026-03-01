<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Twig;

use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\Exception\InvalidArgumentException;
use HechtA\UX\ECharts\Factory\EChartsFactoryInterface;
use HechtA\UX\ECharts\Model\ECharts;
use HechtA\UX\ECharts\Option\Toolbox;
use HechtA\UX\ECharts\Tests\Kernel\TwigAppKernel;
use HechtA\UX\ECharts\Twig\ChartExtension;
use PHPUnit\Framework\TestCase;

class EChartsBundleTest extends TestCase
{
    private static TwigAppKernel $kernel;
    private EChartsBuilderInterface $builder;
    private EChartsFactoryInterface $factory;
    private ChartExtension $twigExtension;

    public static function setUpBeforeClass(): void
    {
        self::$kernel = new TwigAppKernel('test', true);
        self::$kernel->boot();
    }

    public static function tearDownAfterClass(): void
    {
        self::$kernel->shutdown();
    }

    protected function setUp(): void
    {
        $container = self::$kernel->getContainer()->get('test.service_container');
        $this->builder = $container->get('test.echarts.builder');
        $this->factory = $this->builder->factory();
        $this->twigExtension = $container->get('test.echarts.twig_extension');
    }

    public function testRenderChart(): void
    {
        $chart = $this->builder->createECharts(ECharts::TYPE_LINE);

        $chart
            ->addSerie(['data' => [150, 230, 224, 218, 135, 147, 260], 'type' => 'line'])
            ->setWidth(400)
            ->setHeight(200)
            ->setRawOptions([
                'xAxis' => ['type' => 'category', 'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']],
                'yAxis' => ['type' => 'value'],
            ]);

        $rendered = $this->twigExtension->renderECharts($chart, ['class' => 'myclass']);

        $this->assertStringContainsString('height: 200px', $rendered);
        $this->assertStringContainsString('class="myclass"', $rendered);
        $this->assertStringContainsString('hecht-a--ux-echarts--echarts', $rendered);
    }

    public function testRenderWithCustomAttributes(): void
    {
        $chart = $this->builder->createECharts();
        $chart->setAttributes(['id' => 'my-chart', 'class' => 'mb-4']);

        $rendered = $this->twigExtension->renderECharts($chart);
        $this->assertStringContainsString('id="my-chart"', $rendered);
        $this->assertStringContainsString('class="mb-4"', $rendered);
    }

    public function testSetSeriesReplacesAllSeries(): void
    {
        $chart = $this->builder->createECharts();
        $chart
            ->addSerie(['type' => 'line', 'data' => [1, 2, 3]])
            ->setSeries([
                ['type' => 'bar', 'data' => [10, 20, 30]],
                ['type' => 'line', 'data' => [15, 25, 35]],
            ]);

        $view = $chart->createView();
        $this->assertCount(2, $view['options']['series']);
        $this->assertSame('bar', $view['options']['series'][0]['type']);
    }

    public function testSetAttributesMergesWithExistingAttributes(): void
    {
        $chart = $this->builder->createECharts();
        $chart->setAttributes(['class' => 'first']);
        $chart->setAttributes(['id' => 'my-chart']);

        $this->assertSame('first', $chart->getAttributes()['class']);
        $this->assertSame('my-chart', $chart->getAttributes()['id']);
    }

    public function testSetAttributesOverridesExistingKey(): void
    {
        $chart = $this->builder->createECharts();
        $chart->setAttributes(['class' => 'first']);
        $chart->setAttributes(['class' => 'second']);

        $this->assertSame('second', $chart->getAttributes()['class']);
    }

    public function testThemesAreIncludedInView(): void
    {
        $chart = $this->builder->createECharts();
        $chart->addTheme('dark', ['color' => ['#000']]);
        $chart->useTheme('dark');

        $view = $chart->createView();
        $this->assertSame('dark', $view['currentTheme']);
        $this->assertArrayHasKey('dark', $view['themes']);
    }

    public function testEmptyThemesIsArray(): void
    {
        $chart = $this->builder->createECharts();
        $view = $chart->createView();

        $this->assertIsArray($view['themes']);
        $this->assertEmpty($view['themes']);
    }

    public function testDefaultDimensions(): void
    {
        $chart = $this->builder->createECharts();
        $this->assertSame(800, $chart->getWidth());
        $this->assertSame(400, $chart->getHeight());
    }

    public function testSetWidthThrowsOnNonPositiveValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->builder->createECharts()->setWidth(0);
    }

    public function testSetHeightThrowsOnNonPositiveValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->builder->createECharts()->setHeight(-10);
    }

    public function testSetOptionsAreMerged(): void
    {
        $chart = $this->builder->createECharts();
        $chart->setRawOptions(['title' => ['text' => 'Hello']]);
        $chart->setRawOptions(['xAxis' => ['type' => 'category']]);

        $this->assertArrayHasKey('title', $chart->getOptions());
        $this->assertArrayHasKey('xAxis', $chart->getOptions());
    }

    public function testResizableIsEnabledByDefault(): void
    {
        $chart = $this->builder->createECharts();
        $this->assertTrue($chart->isResizable());
    }

    public function testResizableCanBeDisabled(): void
    {
        $chart = $this->builder->createECharts();
        $chart->setResizable(false);
        $this->assertFalse($chart->isResizable());
    }

    public function testResizableRendersWidthAs100Percent(): void
    {
        $chart = $this->builder->createECharts()->setHeight(300);
        $rendered = $this->twigExtension->renderECharts($chart);

        $this->assertStringContainsString('width: 100%', $rendered);
        $this->assertStringContainsString('height: 300px', $rendered);
    }

    public function testNonResizableRendersWidthInPx(): void
    {
        $chart = $this->builder->createECharts()->setWidth(600)->setHeight(300)->setResizable(false);
        $rendered = $this->twigExtension->renderECharts($chart);

        $this->assertStringContainsString('width: 600px', $rendered);
    }

    public function testResizableIsPropagatedToView(): void
    {
        $chart = $this->builder->createECharts();
        $chart->setResizable(false);

        $this->assertFalse($chart->createView()['resizable']);
    }

    public function testExportableAddsToolbox(): void
    {
        $chart = $this->builder->createECharts();
        $chart->exportable();

        $options = $chart->getOptions();
        $this->assertArrayHasKey('toolbox', $options);
        $this->assertTrue($options['toolbox']['show']);
        $this->assertArrayHasKey('saveAsImage', $options['toolbox']['feature']);
        $this->assertArrayHasKey('dataView', $options['toolbox']['feature']);
        $this->assertArrayHasKey('restore', $options['toolbox']['feature']);
    }

    public function testExportableWithCustomToolbox(): void
    {
        $chart = $this->builder->createECharts();
        $chart->exportable(
            (new Toolbox())
                ->saveAsImage('svg')
                ->dataView(readOnly: true)
                ->restore()
        );

        $toolbox = $chart->getOptions()['toolbox'];
        $this->assertSame('svg', $toolbox['feature']['saveAsImage']['type']);
        $this->assertTrue($toolbox['feature']['dataView']['readOnly']);
        $this->assertArrayHasKey('restore', $toolbox['feature']);
        $this->assertArrayNotHasKey('magicType', $toolbox['feature']);
    }

    public function testFactoryIsAccessibleFromBuilder(): void
    {
        $this->assertInstanceOf(EChartsFactoryInterface::class, $this->builder->factory());
    }

    public function testFactoryReturnsSameInstance(): void
    {
        $this->assertSame($this->builder->factory(), $this->builder->factory());
    }

    public function testFactoryCreatesLineChart(): void
    {
        $chart = $this->factory->line([10, 20, 30], ['A', 'B', 'C']);
        $view = $chart->createView();

        $this->assertSame('line', $view['options']['series'][0]['type']);
        $this->assertSame([10, 20, 30], $view['options']['series'][0]['data']);
        $this->assertSame(['A', 'B', 'C'], $view['options']['xAxis']['data']);
    }

    public function testFactoryCreatesBarChart(): void
    {
        $chart = $this->factory->bar([5, 15, 25], ['X', 'Y', 'Z']);
        $view = $chart->createView();

        $this->assertSame('bar', $view['options']['series'][0]['type']);
        $this->assertSame([5, 15, 25], $view['options']['series'][0]['data']);
    }

    public function testFactoryCreatesPieChart(): void
    {
        $chart = $this->factory->pie(['Foo' => 40, 'Bar' => 60]);
        $view = $chart->createView();

        $this->assertSame('pie', $view['options']['series'][0]['type']);
        $this->assertSame([
            ['name' => 'Foo', 'value' => 40],
            ['name' => 'Bar', 'value' => 60],
        ], $view['options']['series'][0]['data']);
    }

    public function testFactoryCreatesRadarChart(): void
    {
        $chart = $this->factory->radar(
            ['Team A' => [80, 90, 70], 'Team B' => [60, 75, 85]],
            ['Speed', 'Strength', 'Stamina'],
        );
        $view = $chart->createView();

        $this->assertSame('radar', $view['options']['series'][0]['type']);
        $this->assertCount(2, $view['options']['series'][0]['data']);
        $this->assertSame([['name' => 'Speed'], ['name' => 'Strength'], ['name' => 'Stamina']], $view['options']['radar']['indicator']);
    }

    public function testFactoryMergesSerieOptions(): void
    {
        $chart = $this->factory->line([1, 2, 3], [], ['name' => 'Revenue', 'smooth' => true]);
        $view = $chart->createView();

        $this->assertSame('Revenue', $view['options']['series'][0]['name']);
        $this->assertTrue($view['options']['series'][0]['smooth']);
    }

    public function testFactoryMergesChartOptions(): void
    {
        $chart = $this->factory->bar([1, 2], [], [], ['title' => ['text' => 'My Bar']]);
        $view = $chart->createView();

        $this->assertSame('My Bar', $view['options']['title']['text']);
    }
}
