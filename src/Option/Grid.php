<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Option;

/**
 * @see https://echarts.apache.org/en/option.html#grid
 */
class Grid extends Option
{
    public function __construct(
        string $left = '10%',
        string $right = '10%',
        string $top = '60',
        string $bottom = '60',
        bool $containLabel = false,
    ) {
        parent::__construct([
            'left' => $left,
            'right' => $right,
            'top' => $top,
            'bottom' => $bottom,
            'containLabel' => $containLabel,
        ]);
    }

    public function left(string $left): static
    {
        return $this->set('left', $left);
    }

    public function right(string $right): static
    {
        return $this->set('right', $right);
    }

    public function top(string $top): static
    {
        return $this->set('top', $top);
    }

    public function bottom(string $bottom): static
    {
        return $this->set('bottom', $bottom);
    }

    public function containLabel(bool $containLabel = true): static
    {
        return $this->set('containLabel', $containLabel);
    }
}
