<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Serie;

abstract class Serie
{
    /** @var array<string, mixed> */
    protected array $data = [];

    public function __construct(string $type, ?string $name = null)
    {
        $this->data['type'] = $type;

        if ($name !== null) {
            $this->data['name'] = $name;
        }
    }

    public function name(string $name): static
    {
        $this->data['name'] = $name;

        return $this;
    }

    /**
     * @param mixed[] $data
     */
    public function data(array $data): static
    {
        $this->data['data'] = $data;

        return $this;
    }

    public function set(string $key, mixed $value): static
    {
        $this->data[$key] = $value;

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
