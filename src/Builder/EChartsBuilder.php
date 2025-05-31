<?php

namespace HechtA\UX\ECharts\Builder;

use HechtA\UX\ECharts\Model\ECharts;

class EChartsBuilder implements EChartsBuilderInterface
{
    public function createECharts(?string $id = null): ECharts
    {
        return new ECharts($id);
    }
}