<?php

namespace Symfony\UX\ECharts\Builder;

use Symfony\UX\ECharts\Model\ECharts;

interface EChartsBuilderInterface
{
    public function createECharts(?string $id = null): ECharts;
}