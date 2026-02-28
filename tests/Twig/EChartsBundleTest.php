<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Twig;

use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\Exception\InvalidArgumentException;
use HechtA\UX\ECharts\Model\ECharts;
use HechtA\UX\ECharts\Tests\Kernel\TwigAppKernel;
use HechtA\UX\ECharts\Twig\ChartExtension;
use PHPUnit\Framework\TestCase;

class EChartsBundleTest extends TestCase
{
    private static TwigAppKernel $kernel;
    private EChartsBuilderInterface $builder;
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
        $this->twigExtension = $container->get('test.echarts.twig_extension');
    }

    public function testRenderChart(): void
    {
        $chart = $this->builder->createECharts(ECharts::TYPE_LINE);

        $chart
            ->addSerie([
                'data' => [150, 230, 224, 218, 135, 147, 260],
                'type' => 'line',
            ])
            ->setWidth(400)
            ->setHeight(200)
            ->setOptions([
                'xAxis' => [
                    'type' => 'category',
                    'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                ],
                'yAxis' => [
                    'type' => 'value',
                ]]);

        $rendered = $this->twigExtension->renderECharts(
            $chart,
            ['data-controller' => 'echarts', 'class' => 'myclass']
        );

        $this->assertStringContainsString('width: 400px', $rendered);
        $this->assertStringContainsString('height: 200px', $rendered);
        $this->assertStringContainsString('class="myclass"', $rendered);
        $this->assertStringContainsString('hecht-a--ux-echarts--echarts', $rendered);
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

        $attributes = $chart->getAttributes();
        $this->assertSame('first', $attributes['class']);
        $this->assertSame('my-chart', $attributes['id']);
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
        $chart->setOptions(['title' => ['text' => 'Hello']]);
        $chart->setOptions(['xAxis' => ['type' => 'category']]);

        $options = $chart->getOptions();
        $this->assertArrayHasKey('title', $options);
        $this->assertArrayHasKey('xAxis', $options);
    }

    public function testRenderWithCustomAttributes(): void
    {
        $chart = $this->builder->createECharts();
        $chart->setAttributes(['id' => 'my-chart', 'class' => 'mb-4']);

        $rendered = $this->twigExtension->renderECharts($chart);
        $this->assertStringContainsString('id="my-chart"', $rendered);
        $this->assertStringContainsString('class="mb-4"', $rendered);
    }
}
