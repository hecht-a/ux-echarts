<?php

namespace HechtA\UX\ECharts\Builder;

use HechtA\UX\ECharts\Model\ECharts;

interface EChartsBuilderInterface
{
    public function createECharts(?string $id = null): ECharts;
}