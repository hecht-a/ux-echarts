<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Factory;

use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\Model\ECharts;

final readonly class EChartsFactory implements EChartsFactoryInterface
{
    public function __construct(
        private EChartsBuilderInterface $builder,
    ) {
    }

    public function line(
        array $data,
        array $xAxis = [],
        array $serieOptions = [],
        array $chartOptions = [],
        ?string $id = null,
    ): ECharts {
        $chart = $this->builder->createECharts($id);

        $chart->setOptions(array_merge([
            'xAxis' => ['type' => 'category', 'data' => $xAxis],
            'yAxis' => ['type' => 'value'],
        ], $chartOptions));

        $chart->addSerie(array_merge([
            'type' => ECharts::TYPE_LINE,
            'data' => $data,
        ], $serieOptions));

        return $chart;
    }

    public function bar(
        array $data,
        array $xAxis = [],
        array $serieOptions = [],
        array $chartOptions = [],
        ?string $id = null,
    ): ECharts {
        $chart = $this->builder->createECharts($id);

        $chart->setOptions(array_merge([
            'xAxis' => ['type' => 'category', 'data' => $xAxis],
            'yAxis' => ['type' => 'value'],
        ], $chartOptions));

        $chart->addSerie(array_merge([
            'type' => ECharts::TYPE_BAR,
            'data' => $data,
        ], $serieOptions));

        return $chart;
    }

    public function pie(
        array $data,
        array $serieOptions = [],
        array $chartOptions = [],
        ?string $id = null,
    ): ECharts {
        $chart = $this->builder->createECharts($id);

        if ($chartOptions !== []) {
            $chart->setOptions($chartOptions);
        }

        $formattedData = array_map(
            static fn (string $name, int|float $value): array => ['name' => $name, 'value' => $value],
            array_keys($data),
            array_values($data),
        );

        $chart->addSerie(array_merge([
            'type' => ECharts::TYPE_PIE,
            'data' => $formattedData,
        ], $serieOptions));

        return $chart;
    }

    public function radar(
        array $data,
        array $indicators = [],
        array $serieOptions = [],
        array $chartOptions = [],
        ?string $id = null,
    ): ECharts {
        $chart = $this->builder->createECharts($id);

        $formattedIndicators = array_map(
            static fn (string $name): array => ['name' => $name],
            $indicators,
        );

        $chart->setOptions(array_merge([
            'radar' => ['indicator' => $formattedIndicators],
        ], $chartOptions));

        $formattedData = array_map(
            static fn (string $name, array $values): array => ['name' => $name, 'value' => $values],
            array_keys($data),
            array_values($data),
        );

        $chart->addSerie(array_merge([
            'type' => ECharts::TYPE_RADAR,
            'data' => $formattedData,
        ], $serieOptions));

        return $chart;
    }
}
