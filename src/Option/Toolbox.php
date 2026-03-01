<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Option;

/**
 * @see https://echarts.apache.org/en/option.html#toolbox
 */
class Toolbox extends Option
{
    /** @var array<string, mixed> */
    private array $features = [];

    public function __construct()
    {
        parent::__construct(['show' => true]);
    }

    public function toArray(): array
    {
        return array_merge($this->data, ['feature' => $this->features]);
    }

    public static function default(): self
    {
        return (new self())
            ->saveAsImage()
            ->dataView()
            ->restore();
    }

    /**
     * @param 'png'|'svg' $type
     */
    public function saveAsImage(string $type = 'png', string $title = 'Save as image'): static
    {
        $this->features['saveAsImage'] = ['type' => $type, 'title' => $title];

        return $this;
    }

    public function dataView(bool $readOnly = false, string $title = 'Data view'): static
    {
        $this->features['dataView'] = [
            'show' => true,
            'readOnly' => $readOnly,
            'title' => $title,
        ];

        return $this;
    }

    public function restore(string $title = 'Restore'): static
    {
        $this->features['restore'] = ['show' => true, 'title' => $title];

        return $this;
    }

    public function dataZoom(string $title = 'Zoom'): static
    {
        $this->features['dataZoom'] = ['show' => true, 'title' => $title];

        return $this;
    }

    /**
     * @param list<'line'|'bar'|'stack'|'tiled'> $types
     */
    public function magicType(array $types = ['line', 'bar']): static
    {
        $this->features['magicType'] = ['show' => true, 'type' => $types];

        return $this;
    }

    public function show(bool $show = true): static
    {
        return $this->set('show', $show);
    }

    /**
     * @param 'left'|'center'|'right'|string $left
     */
    public function left(string $left): static
    {
        return $this->set('left', $left);
    }

    /**
     * @param 'top'|'middle'|'bottom'|string $top
     */
    public function top(string $top): static
    {
        return $this->set('top', $top);
    }
}
