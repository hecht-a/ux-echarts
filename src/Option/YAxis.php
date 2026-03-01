<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Option;

/**
 * @see https://echarts.apache.org/en/option.html#yAxis
 */
class YAxis extends Option
{
    public function __construct(string $type = 'value')
    {
        parent::__construct(['type' => $type]);
    }

    /**
     * @param 'value'|'category'|'time'|'log' $type
     */
    public function type(string $type): static
    {
        return $this->set('type', $type);
    }

    public function name(string $name): static
    {
        return $this->set('name', $name);
    }

    public function min(int|float $min): static
    {
        return $this->set('min', $min);
    }

    public function max(int|float $max): static
    {
        return $this->set('max', $max);
    }
}
