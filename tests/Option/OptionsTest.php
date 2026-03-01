<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Option;

use HechtA\UX\ECharts\Option\Grid;
use HechtA\UX\ECharts\Option\Legend;
use HechtA\UX\ECharts\Option\Option;
use HechtA\UX\ECharts\Option\Options;
use HechtA\UX\ECharts\Option\Title;
use HechtA\UX\ECharts\Option\Tooltip;
use HechtA\UX\ECharts\Option\XAxis;
use HechtA\UX\ECharts\Option\YAxis;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
    public function testInitiallyEmpty(): void
    {
        $this->assertSame([], (new Options())->toArray());
    }

    public function testTitleIsSetCorrectly(): void
    {
        $options = (new Options())->title(new Title('My chart'));

        $this->assertSame(['text' => 'My chart'], $options->toArray()['title']);
    }

    public function testTooltipIsSetCorrectly(): void
    {
        $options = (new Options())->tooltip(new Tooltip('axis'));

        $this->assertSame('axis', $options->toArray()['tooltip']['trigger']);
    }

    public function testLegendIsSetCorrectly(): void
    {
        $options = (new Options())->legend(new Legend(['Email', 'Direct']));

        $this->assertSame(['Email', 'Direct'], $options->toArray()['legend']['data']);
    }

    public function testGridIsSetCorrectly(): void
    {
        $options = (new Options())->grid(new Grid(left: '3%', containLabel: true));

        $this->assertSame('3%', $options->toArray()['grid']['left']);
        $this->assertTrue($options->toArray()['grid']['containLabel']);
    }

    public function testXAxisIsSetCorrectly(): void
    {
        $options = (new Options())->xAxis(new XAxis(data: ['Mon', 'Tue']));

        $this->assertSame(['Mon', 'Tue'], $options->toArray()['xAxis']['data']);
    }

    public function testYAxisIsSetCorrectly(): void
    {
        $options = (new Options())->yAxis(new YAxis('log'));

        $this->assertSame('log', $options->toArray()['yAxis']['type']);
    }

    public function testSetStoresScalarValue(): void
    {
        $options = (new Options())->set('backgroundColor', '#fff');

        $this->assertSame('#fff', $options->toArray()['backgroundColor']);
    }

    public function testSetFlattensOptionObject(): void
    {
        $options = (new Options())->set('textStyle', new Option(['fontSize' => 14]));

        $this->assertSame(['fontSize' => 14], $options->toArray()['textStyle']);
    }

    public function testSetOverwritesExistingKey(): void
    {
        $options = (new Options())
            ->set('animation', true)
            ->set('animation', false);

        $this->assertFalse($options->toArray()['animation']);
    }

    public function testFullChainProducesCorrectArray(): void
    {
        $options = (new Options())
            ->title(new Title('Revenue'))
            ->tooltip(new Tooltip('axis'))
            ->legend(new Legend(['A', 'B']))
            ->grid(new Grid(left: '5%'))
            ->xAxis(new XAxis(data: ['Jan', 'Feb']))
            ->yAxis(new YAxis())
            ->set('animation', false);

        $array = $options->toArray();

        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('tooltip', $array);
        $this->assertArrayHasKey('legend', $array);
        $this->assertArrayHasKey('grid', $array);
        $this->assertArrayHasKey('xAxis', $array);
        $this->assertArrayHasKey('yAxis', $array);
        $this->assertFalse($array['animation']);
    }

    public function testSetOptionsOnChartMergesData(): void
    {
        $chart = new \HechtA\UX\ECharts\Model\ECharts();
        $chart->setOptions((new Options())->title(new Title('First')));
        $chart->setOptions((new Options())->set('animation', false));

        $chartOptions = $chart->getOptions();
        $this->assertArrayHasKey('title', $chartOptions);
        $this->assertArrayHasKey('animation', $chartOptions);
    }
}
