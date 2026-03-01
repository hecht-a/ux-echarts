<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Option;

use HechtA\UX\ECharts\Option\Tooltip;
use PHPUnit\Framework\TestCase;

class TooltipTest extends TestCase
{
    public function testDefaultTriggerIsItem(): void
    {
        $this->assertSame('item', (new Tooltip())->toArray()['trigger']);
    }

    public function testConstructorSetsTrigger(): void
    {
        $this->assertSame('axis', (new Tooltip('axis'))->toArray()['trigger']);
    }

    public function testTrigger(): void
    {
        $tooltip = (new Tooltip())->trigger('none');
        $this->assertSame('none', $tooltip->toArray()['trigger']);
    }

    public function testFormatter(): void
    {
        $tooltip = (new Tooltip())->formatter('{b}: {c}');
        $this->assertSame('{b}: {c}', $tooltip->toArray()['formatter']);
    }

    public function testAxisPointer(): void
    {
        $tooltip = (new Tooltip())->axisPointer('shadow');
        $this->assertSame(['type' => 'shadow'], $tooltip->toArray()['axisPointer']);
    }
}
