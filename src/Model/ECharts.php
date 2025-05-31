<?php

namespace Symfony\UX\ECharts\Model;

class ECharts
{
    public const string TYPE_LINE = 'line';
    public const string TYPE_BAR = 'bar';
    public const string TYPE_PIE = 'pie';
    public const string TYPE_RADAR = 'radar';

    private array $options = [];
    private array $attributes = [];
    private array $series = [];
    private array $themes = [];
    private ?string $currentTheme = null;

    public function __construct(private readonly ?string $id = null)
    {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function addTheme(string $themeName, array $theme): self
    {
        $this->themes[$themeName] = $theme;

        return $this;
    }

    public function useTheme(string $themeName): self
    {
        $this->currentTheme = $themeName;

        return $this;
    }

    public function addSerie(array $serie): self
    {
        $this->series[] = $serie;

        return $this;
    }

    public function setSeries(array $series): self
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Sets ECharts options.
     * @see https://echarts.apache.org/en/option.html
     *
     * <code>
     *    $chart->setOptions([
     *      'xAxis' => [
     *          'type' => 'category',
     *          'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
     *      ],
     *      'yAxis' => [
     *          'type' => 'value',
     *      ]]);
     * </code>
     *
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function createView(): array
    {
        return [
            'options' => [...$this->options, 'series' => $this->series],
            'attributes' => $this->attributes,
            'themes' => $this->themes,
            'currentTheme' => $this->currentTheme,
        ];
    }


    public function getDataController(): ?string
    {
        return $this->attributes['data_controller'] ?? null;
    }

    public function getOptions(): array
    {
        return $this->options;
    }


    public function getAttributes(): array
    {
        return $this->attributes;
    }
}