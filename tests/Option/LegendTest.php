<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Option;

use HechtA\UX\ECharts\Option\Legend;
use PHPUnit\Framework\TestCase;

class LegendTest extends TestCase
{
    public function testDefaultConstructorIsEmpty(): void
    {
        $this->assertSame([], (new Legend())->toArray());
    }

    public function testConstructorSetsData(): void
    {
        $legend = new Legend(['Email', 'Direct']);
        $this->assertSame(['Email', 'Direct'], $legend->toArray()['data']);
    }

    public function testData(): void
    {
        $legend = (new Legend())->data(['A', 'B', 'C']);
        $this->assertSame(['A', 'B', 'C'], $legend->toArray()['data']);
    }

    public function testTop(): void
    {
        $legend = (new Legend())->top('10%');
        $this->assertSame('10%', $legend->toArray()['top']);
    }

    public function testLeft(): void
    {
        $legend = (new Legend())->left('center');
        $this->assertSame('center', $legend->toArray()['left']);
    }

    public function testOrient(): void
    {
        $legend = (new Legend())->orient('vertical');
        $this->assertSame('vertical', $legend->toArray()['orient']);
    }
}
