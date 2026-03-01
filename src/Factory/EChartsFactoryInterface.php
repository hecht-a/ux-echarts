<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Factory;

use HechtA\UX\ECharts\Model\ECharts;

interface EChartsFactoryInterface
{
    /**
     * Creates a line chart.
     *
     * @param list<int|float>      $data
     * @param list<string>         $xAxis
     * @param array<string, mixed> $serieOptions
     * @param array<string, mixed> $chartOptions
     */
    public function line(
        array $data,
        array $xAxis = [],
        array $serieOptions = [],
        array $chartOptions = [],
        ?string $id = null,
    ): ECharts;

    /**
     * Creates a bar chart.
     *
     * @param list<int|float>      $data
     * @param list<string>         $xAxis
     * @param array<string, mixed> $serieOptions
     * @param array<string, mixed> $chartOptions
     */
    public function bar(
        array $data,
        array $xAxis = [],
        array $serieOptions = [],
        array $chartOptions = [],
        ?string $id = null,
    ): ECharts;

    /**
     * Creates a pie chart.
     *
     * @param array<string, int|float> $data
     * @param array<string, mixed>     $serieOptions
     * @param array<string, mixed>     $chartOptions
     */
    public function pie(
        array $data,
        array $serieOptions = [],
        array $chartOptions = [],
        ?string $id = null,
    ): ECharts;

    /**
     * Creates a radar chart.
     *
     * @param array<string, list<int|float>> $data
     * @param list<string>                   $indicators
     * @param array<string, mixed>           $serieOptions
     * @param array<string, mixed>           $chartOptions
     */
    public function radar(
        array $data,
        array $indicators = [],
        array $serieOptions = [],
        array $chartOptions = [],
        ?string $id = null,
    ): ECharts;
}
