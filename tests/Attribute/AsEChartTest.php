<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Attribute;

use HechtA\UX\ECharts\Attribute\AsEChart;
use PHPUnit\Framework\TestCase;

class AsEChartTest extends TestCase
{
    public function testIdIsStored(): void
    {
        $attribute = new AsEChart(id: 'weekly_sales');

        $this->assertSame('weekly_sales', $attribute->id);
    }

    public function testIsAPhpAttribute(): void
    {
        $reflection = new \ReflectionClass(AsEChart::class);
        $attributes = $reflection->getAttributes(\Attribute::class);

        $this->assertNotEmpty($attributes);
    }

    public function testTargetsClassOnly(): void
    {
        $reflection = new \ReflectionClass(AsEChart::class);
        /** @var \Attribute $phpAttribute */
        $phpAttribute = $reflection->getAttributes(\Attribute::class)[0]->newInstance();

        $this->assertSame(\Attribute::TARGET_CLASS, $phpAttribute->flags);
    }
}
