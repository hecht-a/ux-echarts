<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\DataCollector;

use HechtA\UX\ECharts\DataCollector\EChartsDataCollector;
use HechtA\UX\ECharts\Model\ECharts;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EChartsDataCollectorTest extends TestCase
{
    private EChartsDataCollector $collector;

    protected function setUp(): void
    {
        $this->collector = new EChartsDataCollector();
    }

    public function testInitiallyEmpty(): void
    {
        $this->assertSame(0, $this->collector->getChartCount());
        $this->assertSame([], $this->collector->getCharts());
    }

    public function testRecordStoresChartId(): void
    {
        $this->collector->record(new ECharts('my_chart'));

        $this->assertSame('my_chart', $this->collector->getCharts()[0]['id']);
    }

    public function testRecordUsesPlaceholderWhenNoId(): void
    {
        $this->collector->record(new ECharts());

        $this->assertSame('(no id)', $this->collector->getCharts()[0]['id']);
    }

    public function testRecordStoresSeriesCount(): void
    {
        $chart = new ECharts();
        $chart->addSerie(['type' => 'line', 'data' => [1, 2, 3]]);
        $chart->addSerie(['type' => 'bar', 'data' => [4, 5, 6]]);

        $this->collector->record($chart);

        $this->assertSame(2, $this->collector->getCharts()[0]['series_count']);
    }

    public function testRecordStoresZeroSeriesWhenNoneAdded(): void
    {
        $this->collector->record(new ECharts());

        $this->assertSame(0, $this->collector->getCharts()[0]['series_count']);
    }

    public function testRecordStoresTheme(): void
    {
        $chart = new ECharts();
        $chart->addTheme('dark', [])->useTheme('dark');

        $this->collector->record($chart);

        $this->assertSame('dark', $this->collector->getCharts()[0]['theme']);
    }

    public function testRecordStoresNullThemeWhenNoneSet(): void
    {
        $this->collector->record(new ECharts());

        $this->assertNull($this->collector->getCharts()[0]['theme']);
    }

    public function testRecordStoresDimensions(): void
    {
        $chart = new ECharts();
        $chart->setWidth(600)->setHeight(300);

        $this->collector->record($chart);

        $entry = $this->collector->getCharts()[0];
        $this->assertSame(600, $entry['width']);
        $this->assertSame(300, $entry['height']);
    }

    public function testRecordStoresResizableTrue(): void
    {
        $this->collector->record(new ECharts());

        $this->assertTrue($this->collector->getCharts()[0]['resizable']);
    }

    public function testRecordStoresResizableFalse(): void
    {
        $chart = new ECharts();
        $chart->setResizable(false);

        $this->collector->record($chart);

        $this->assertFalse($this->collector->getCharts()[0]['resizable']);
    }

    public function testRecordStoresExportableTrue(): void
    {
        $chart = new ECharts();
        $chart->exportable();

        $this->collector->record($chart);

        $this->assertTrue($this->collector->getCharts()[0]['exportable']);
    }

    public function testRecordStoresExportableFalseWhenNoToolbox(): void
    {
        $this->collector->record(new ECharts());

        $this->assertFalse($this->collector->getCharts()[0]['exportable']);
    }

    public function testRecordStoresOptionsJson(): void
    {
        $chart = new ECharts();
        $chart->setOptions(['title' => ['text' => 'Hello']]);

        $this->collector->record($chart);

        $json = $this->collector->getCharts()[0]['options_json'];
        $this->assertIsString($json);
        $decoded = json_decode($json, true);
        $this->assertSame('Hello', $decoded['title']['text']);
    }

    public function testChartCountIncrementsOnEachRecord(): void
    {
        $this->collector->record(new ECharts('a'));
        $this->collector->record(new ECharts('b'));
        $this->collector->record(new ECharts('c'));

        $this->assertSame(3, $this->collector->getChartCount());
    }

    public function testResetClearsAllData(): void
    {
        $this->collector->record(new ECharts('a'));
        $this->collector->record(new ECharts('b'));

        $this->collector->reset();

        $this->assertSame(0, $this->collector->getChartCount());
        $this->assertSame([], $this->collector->getCharts());
    }

    public function testCollectDoesNotAlterData(): void
    {
        $chart = new ECharts('my_chart');
        $this->collector->record($chart);

        $this->collector->collect(new Request(), new Response());

        $this->assertSame(1, $this->collector->getChartCount());
    }

    public function testGetName(): void
    {
        $this->assertSame('echarts', $this->collector->getName());
    }

    public function testGetTemplate(): void
    {
        $this->assertStringContainsString('echarts.html.twig', EChartsDataCollector::getTemplate());
    }
}
