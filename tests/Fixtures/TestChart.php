<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Fixtures;

use HechtA\UX\ECharts\Attribute\AsEChart;
use HechtA\UX\ECharts\Chart\AbstractECharts;
use HechtA\UX\ECharts\Model\ECharts;

#[AsEChart(id: 'test_chart')]
class TestChart extends AbstractECharts
{
    public function configure(ECharts $chart): void
    {
        $chart
            ->setHeight(300)
            ->addSerie(['type' => ECharts::TYPE_LINE, 'data' => [1, 2, 3]]);
    }
}
