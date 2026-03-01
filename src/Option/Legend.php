<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Option;

/**
 * @see https://echarts.apache.org/en/option.html#legend
 */
class Legend extends Option
{
    /**
     * @param string[] $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data !== [] ? ['data' => $data] : []);
    }

    /**
     * @param string[] $data
     */
    public function data(array $data): static
    {
        return $this->set('data', $data);
    }

    public function top(string $top): static
    {
        return $this->set('top', $top);
    }

    public function left(string $left): static
    {
        return $this->set('left', $left);
    }

    /**
     * @param 'horizontal'|'vertical' $orient
     */
    public function orient(string $orient): static
    {
        return $this->set('orient', $orient);
    }
}
