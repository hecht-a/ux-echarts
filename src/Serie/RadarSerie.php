<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Serie;

class RadarSerie extends Serie
{
    public function __construct(?string $name = null)
    {
        parent::__construct('radar', $name);
    }

    public static function new(?string $name = null): self
    {
        return new self($name);
    }

    public function data(array $data): static
    {
        $formatted = array_map(
            static fn (mixed $name, mixed $values): array => ['name' => $name, 'value' => $values],
            array_keys($data),
            array_values($data),
        );

        $this->data['data'] = $formatted;

        return $this;
    }
}
