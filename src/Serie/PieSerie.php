<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Serie;

class PieSerie extends Serie
{
    public function __construct(?string $name = null)
    {
        parent::__construct('pie', $name);
    }

    public static function new(?string $name = null): self
    {
        return new self($name);
    }

    public function data(array $data): static
    {
        $formatted = array_map(
            static fn (mixed $name, mixed $value): array => ['name' => $name, 'value' => $value],
            array_keys($data),
            array_values($data),
        );

        $this->data['data'] = $formatted;

        return $this;
    }

    public function radius(string $inner, string $outer = '70%'): static
    {
        return $this->set('radius', [$inner, $outer]);
    }

    public function center(string $x, string $y): static
    {
        return $this->set('center', [$x, $y]);
    }

    public function roseType(string $type = 'area'): static
    {
        return $this->set('roseType', $type);
    }
}
