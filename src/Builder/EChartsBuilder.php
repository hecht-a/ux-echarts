<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Builder;

use HechtA\UX\ECharts\Factory\EChartsFactory;
use HechtA\UX\ECharts\Factory\EChartsFactoryInterface;
use HechtA\UX\ECharts\Model\ECharts;

class EChartsBuilder implements EChartsBuilderInterface
{
    private ?EChartsFactoryInterface $factory = null;

    public function createECharts(?string $id = null): ECharts
    {
        return new ECharts($id);
    }

    public function factory(): EChartsFactoryInterface
    {
        return $this->factory ??= new EChartsFactory($this);
    }
}
