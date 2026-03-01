<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Option;

use HechtA\UX\ECharts\Option\Grid;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $grid = new Grid();
        $array = $grid->toArray();

        $this->assertSame('10%', $array['left']);
        $this->assertSame('10%', $array['right']);
        $this->assertSame('60', $array['top']);
        $this->assertSame('60', $array['bottom']);
        $this->assertFalse($array['containLabel']);
    }

    public function testConstructorWithCustomValues(): void
    {
        $grid = new Grid(left: '3%', right: '4%', containLabel: true);
        $array = $grid->toArray();

        $this->assertSame('3%', $array['left']);
        $this->assertSame('4%', $array['right']);
        $this->assertTrue($array['containLabel']);
    }

    public function testLeft(): void
    {
        $this->assertSame('5%', (new Grid())->left('5%')->toArray()['left']);
    }

    public function testRight(): void
    {
        $this->assertSame('5%', (new Grid())->right('5%')->toArray()['right']);
    }

    public function testTop(): void
    {
        $this->assertSame('80', (new Grid())->top('80')->toArray()['top']);
    }

    public function testBottom(): void
    {
        $this->assertSame('40', (new Grid())->bottom('40')->toArray()['bottom']);
    }

    public function testContainLabel(): void
    {
        $this->assertTrue((new Grid())->containLabel()->toArray()['containLabel']);
        $this->assertFalse((new Grid())->containLabel(false)->toArray()['containLabel']);
    }
}
