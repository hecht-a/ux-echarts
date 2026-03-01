<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Registry;

use HechtA\UX\ECharts\Chart\EchartsInterface;

interface EChartsRegistryInterface
{
    public function add(string $id, EchartsInterface $chart): void;

    public function get(string $id): EchartsInterface;

    public function has(string $id): bool;

    /**
     * @return array<string, EchartsInterface>
     */
    public function all(): array;

    /**
     * @param class-string $className
     */
    public function findByClass(string $className): ?EchartsInterface;
}
