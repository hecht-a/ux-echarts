<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\DataCollector;

use HechtA\UX\ECharts\Model\ECharts;
use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class EChartsDataCollector extends AbstractDataCollector
{
    public function collect(Request $request, Response $response, ?\Throwable $exception = null): void
    {
    }

    public function record(ECharts $chart): void
    {
        $options = $chart->getOptions();
        $seriesCount = \count($chart->getSeries());
        /** @var array<string, mixed> $toolbox */
        $toolbox = $options['toolbox'] ?? [];
        $hasToolbox = isset($toolbox['show']) && $toolbox['show'] === true;

        $this->data['charts'][] = [
            'id' => $chart->getId() ?? '(no id)',
            'series_count' => $seriesCount,
            'theme' => $chart->getTheme(),
            'resizable' => $chart->isResizable(),
            'width' => $chart->getWidth(),
            'height' => $chart->getHeight(),
            'exportable' => $hasToolbox,
            'options_json' => json_encode($options, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE),
        ];
    }

    public function getChartCount(): int
    {
        return \count($this->data['charts'] ?? []);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getCharts(): array
    {
        return $this->data['charts'] ?? [];
    }

    public static function getTemplate(): string
    {
        return '@ECharts/collector/echarts.html.twig';
    }

    public function getName(): string
    {
        return 'echarts';
    }

    public function reset(): void
    {
        $this->data = [];
    }
}
