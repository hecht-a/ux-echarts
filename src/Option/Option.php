<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Option;

class Option
{
    /** @var array<string, mixed> */
    protected array $data;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function set(string $key, mixed $value): static
    {
        $this->data[$key] = $value instanceof self ? $value->toArray() : $value;

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
