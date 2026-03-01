<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Registry;

use HechtA\UX\ECharts\Chart\EchartsInterface;
use HechtA\UX\ECharts\Exception\InvalidArgumentException;

final class EChartsRegistry implements EChartsRegistryInterface
{
    /** @var array<string, EchartsInterface> */
    private array $charts = [];

    public function add(string $id, EchartsInterface $chart): void
    {
        $this->charts[$id] = $chart;
    }

    public function get(string $id): EchartsInterface
    {
        if (!isset($this->charts[$id])) {
            throw new InvalidArgumentException(\sprintf('No chart registered with id "%s". Did you forget to add #[AsEChart] to your class?', $id, ));
        }

        return $this->charts[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->charts[$id]);
    }

    public function all(): array
    {
        return $this->charts;
    }

    public function findByClass(string $className): ?EchartsInterface
    {
        foreach ($this->charts as $chart) {
            if ($chart instanceof $className) {
                return $chart;
            }
        }

        return null;
    }
}
