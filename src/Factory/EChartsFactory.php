<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Factory;

use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\Model\ECharts;
use HechtA\UX\ECharts\Option\Options;
use HechtA\UX\ECharts\Option\XAxis;
use HechtA\UX\ECharts\Option\YAxis;
use HechtA\UX\ECharts\Serie\BarSerie;
use HechtA\UX\ECharts\Serie\LineSerie;
use HechtA\UX\ECharts\Serie\PieSerie;
use HechtA\UX\ECharts\Serie\RadarSerie;

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

        $chart->setOptions(
            (new Options())
                ->xAxis(new XAxis(data: $xAxis))
                ->yAxis(new YAxis())
        );

        if ($chartOptions !== []) {
            $chart->setRawOptions($chartOptions);
        }

        $serie = LineSerie::new()->data($data);
        foreach ($serieOptions as $key => $value) {
            $serie->set($key, $value);
        }

        $chart->addSerie($serie);

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

        $options = (new Options())
            ->xAxis(new XAxis(data: $xAxis))
            ->yAxis(new YAxis());

        $chart->setOptions($options);

        if ($chartOptions !== []) {
            $chart->setRawOptions($chartOptions);
        }

        $serie = BarSerie::new()->data($data);
        foreach ($serieOptions as $key => $value) {
            $serie->set($key, $value);
        }

        $chart->addSerie($serie);

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
            $chart->setRawOptions($chartOptions);
        }

        $serie = PieSerie::new()->data($data);
        foreach ($serieOptions as $key => $value) {
            $serie->set($key, $value);
        }

        $chart->addSerie($serie);

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

        $chart->setRawOptions(array_merge(
            ['radar' => ['indicator' => $formattedIndicators]],
            $chartOptions,
        ));

        $serie = RadarSerie::new()->data($data);
        foreach ($serieOptions as $key => $value) {
            $serie->set($key, $value);
        }

        $chart->addSerie($serie);

        return $chart;
    }
}
