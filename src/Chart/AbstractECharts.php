<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Chart;

use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\Model\ECharts;

abstract class AbstractECharts implements EchartsInterface
{
    private ?ECharts $chart = null;

    public function __construct(
        private readonly EChartsBuilderInterface $builder,
    ) {
    }

    public function get(): ?ECharts
    {
        if ($this->chart === null) {
            $this->chart = $this->builder->createECharts();
            $this->configure($this->chart);
        }

        return $this->chart;
    }
}
