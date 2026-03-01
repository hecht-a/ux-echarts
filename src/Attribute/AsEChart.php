<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class AsEChart
{
    public function __construct(
        public string $id,
    ) {
    }
}
