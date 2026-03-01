<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Option;

final class Options
{
    /** @var array<string, mixed> */
    private array $data = [];

    public function title(Title $title): static
    {
        $this->data['title'] = $title->toArray();

        return $this;
    }

    public function tooltip(Tooltip $tooltip): static
    {
        $this->data['tooltip'] = $tooltip->toArray();

        return $this;
    }

    public function legend(Legend $legend): static
    {
        $this->data['legend'] = $legend->toArray();

        return $this;
    }

    public function grid(Grid $grid): static
    {
        $this->data['grid'] = $grid->toArray();

        return $this;
    }

    public function xAxis(XAxis $xAxis): static
    {
        $this->data['xAxis'] = $xAxis->toArray();

        return $this;
    }

    public function yAxis(YAxis $yAxis): static
    {
        $this->data['yAxis'] = $yAxis->toArray();

        return $this;
    }

    public function set(string $key, mixed $value): static
    {
        $this->data[$key] = $value instanceof Option ? $value->toArray() : $value;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
