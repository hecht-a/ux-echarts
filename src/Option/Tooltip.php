<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Option;

/**
 * @see https://echarts.apache.org/en/option.html#tooltip
 */
class Tooltip extends Option
{
    public function __construct(string $trigger = 'item')
    {
        parent::__construct(['trigger' => $trigger]);
    }

    /**
     * @param 'item'|'axis'|'none' $trigger
     */
    public function trigger(string $trigger): static
    {
        return $this->set('trigger', $trigger);
    }

    public function formatter(string $formatter): static
    {
        return $this->set('formatter', $formatter);
    }

    public function axisPointer(string $type): static
    {
        return $this->set('axisPointer', ['type' => $type]);
    }
}
