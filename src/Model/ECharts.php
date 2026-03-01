<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Model;

use HechtA\UX\ECharts\Exception\InvalidArgumentException;

class ECharts
{
    public const string TYPE_LINE = 'line';
    public const string TYPE_BAR = 'bar';
    public const string TYPE_PIE = 'pie';
    public const string TYPE_RADAR = 'radar';

    /** @var array<string, mixed> */
    private array $options = [];
    /** @var array<string, string|bool|int|float> */
    private array $attributes = [];
    /** @var array<string|int, mixed> */
    private array $series = [];
    /** @var array<string, mixed> */
    private array $themes = [];
    private ?string $currentTheme = null;
    private int $width = 800;
    private int $height = 400;
    private bool $resizable = true;

    public function __construct(
        private readonly ?string $id = null,
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param array<string, mixed> $theme
     */
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

    /**
     * @param array<string, mixed> $serie
     */
    public function addSerie(array $serie): self
    {
        $this->series[] = $serie;

        return $this;
    }

    /**
     * @param array<string, mixed> $series
     */
    public function setSeries(array $series): self
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Sets ECharts options.
     *
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
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @param array<string, string|bool|int|float> $attributes
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    public function setWidth(int $width): self
    {
        if ($width <= 0) {
            throw new InvalidArgumentException(\sprintf('Width must be a positive integer, %d given.', $width));
        }
        $this->width = $width;

        return $this;
    }

    public function setHeight(int $height): self
    {
        if ($height <= 0) {
            throw new InvalidArgumentException(\sprintf('Height must be a positive integer, %d given.', $height));
        }
        $this->height = $height;

        return $this;
    }

    public function setResizable(bool $resizable): self
    {
        $this->resizable = $resizable;

        return $this;
    }

    public function isResizable(): bool
    {
        return $this->resizable;
    }

    /**
     * @return array<string, mixed>
     */
    public function createView(): array
    {
        return [
            'options' => [...$this->options, 'series' => $this->series],
            'attributes' => $this->attributes,
            'themes' => $this->themes,
            'currentTheme' => $this->currentTheme,
            'resizable' => $this->resizable,
        ];
    }

    public function getDataController(): ?string
    {
        /** @var ?string $dataController */
        $dataController = $this->attributes['data_controller'] ?? null;

        return $dataController;
    }

    /**
     * @return array<string|int, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return array<string, string|bool|int|float>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}
