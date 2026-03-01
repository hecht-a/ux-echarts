<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Chart;

use HechtA\UX\ECharts\Model\ECharts;

interface EchartsInterface
{
    public function configure(ECharts $chart): void;

    public function get(): ?ECharts;
}
