<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Option;

/**
 * @see https://echarts.apache.org/en/option.html#xAxis
 */
class XAxis extends Option
{
    /**
     * @param string[] $data
     */
    public function __construct(
        string $type = 'category',
        array $data = [],
    ) {
        parent::__construct(['type' => $type]);

        if ($data !== []) {
            $this->set('data', $data);
        }
    }

    /**
     * @param 'value'|'category'|'time'|'log' $type
     */
    public function type(string $type): static
    {
        return $this->set('type', $type);
    }

    /**
     * @param string[] $data
     */
    public function data(array $data): static
    {
        return $this->set('data', $data);
    }

    public function name(string $name): static
    {
        return $this->set('name', $name);
    }

    public function boundaryGap(bool $boundaryGap): static
    {
        return $this->set('boundaryGap', $boundaryGap);
    }
}
