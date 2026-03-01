<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Model;

use HechtA\UX\ECharts\Exception\InvalidArgumentException;
use HechtA\UX\ECharts\Option\Options;
use HechtA\UX\ECharts\Option\Toolbox;
use HechtA\UX\ECharts\Serie\Serie;

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

    public function getTheme(): ?string
    {
        return $this->currentTheme;
    }

    /**
     * @param Serie|array<string, mixed> $serie
     */
    public function addSerie(Serie|array $serie): self
    {
        $this->series[] = $serie instanceof Serie ? $serie->toArray() : $serie;

        return $this;
    }

    /**
     * @param (Serie|array<string, mixed>)[] $series
     */
    public function setSeries(array $series): self
    {
        $this->series = array_map(
            fn (Serie|array $serie): array => $serie instanceof Serie
                ? $serie->toArray()
                : $serie,
            $series,
        );

        return $this;
    }

    /**
     * @return array<string|int, mixed>
     */
    public function getSeries(): array
    {
        return $this->series;
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
     * @return $this
     */
    public function setOptions(Options $options): self
    {
        $this->options = array_merge($this->options, $options->toArray());

        return $this;
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    public function setRawOptions(array $options): self
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

    public function exportable(?Toolbox $toolbox = null): self
    {
        $this->options['toolbox'] = ($toolbox ?? Toolbox::default())->toArray();

        return $this;
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
