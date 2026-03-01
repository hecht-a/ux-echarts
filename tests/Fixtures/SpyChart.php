<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Fixtures;

use HechtA\UX\ECharts\Attribute\AsEChart;
use HechtA\UX\ECharts\Chart\AbstractECharts;
use HechtA\UX\ECharts\Model\ECharts;

#[AsEChart(id: 'spy_chart')]
class SpyChart extends AbstractECharts
{
    public int $configureCalls = 0;

    public function configure(ECharts $chart): void
    {
        ++$this->configureCalls;
    }
}
