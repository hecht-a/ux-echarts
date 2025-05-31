<?php

namespace Symfony\UX\ECharts\Builder;

use Symfony\UX\ECharts\Model\ECharts;

class EChartsBuilder implements EChartsBuilderInterface
{
    public function createECharts(?string $id = null): ECharts
    {
        return new ECharts($id);
    }
}