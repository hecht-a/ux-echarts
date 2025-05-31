<?php

namespace HechtA\UX\ECharts;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EChartsBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}