<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Serie;

class BarSerie extends Serie
{
    public function __construct(?string $name = null)
    {
        parent::__construct('bar', $name);
    }

    public static function new(?string $name = null): self
    {
        return new self($name);
    }

    public function stack(string $stack): static
    {
        return $this->set('stack', $stack);
    }

    public function barWidth(string|int $width): static
    {
        return $this->set('barWidth', $width);
    }

    public function barMaxWidth(string|int $width): static
    {
        return $this->set('barMaxWidth', $width);
    }
}
