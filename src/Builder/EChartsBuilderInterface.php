<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Builder;

use HechtA\UX\ECharts\Factory\EChartsFactoryInterface;
use HechtA\UX\ECharts\Model\ECharts;

interface EChartsBuilderInterface
{
    public function createECharts(?string $id = null): ECharts;

    public function factory(): EChartsFactoryInterface;
}
