<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Fixtures;

use HechtA\UX\ECharts\Serie\Serie;

class ConcreteSerie extends Serie
{
    public function __construct(?string $name = null)
    {
        parent::__construct('custom', $name);
    }
}
