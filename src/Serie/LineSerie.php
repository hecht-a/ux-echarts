<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Serie;

class LineSerie extends Serie
{
    public function __construct(?string $name = null)
    {
        parent::__construct('line', $name);
    }

    public static function new(?string $name = null): self
    {
        return new self($name);
    }

    public function smooth(bool $smooth = true): static
    {
        return $this->set('smooth', $smooth);
    }

    public function stack(string $stack): static
    {
        return $this->set('stack', $stack);
    }

    public function areaStyle(): static
    {
        return $this->set('areaStyle', new \stdClass());
    }

    public function step(string|bool $step): static
    {
        return $this->set('step', $step);
    }
}
