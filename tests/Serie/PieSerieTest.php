<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Serie;

use HechtA\UX\ECharts\Serie\PieSerie;
use PHPUnit\Framework\TestCase;

class PieSerieTest extends TestCase
{
    public function testTypeIsPie(): void
    {
        $this->assertSame('pie', PieSerie::new()->toArray()['type']);
    }

    public function testDataIsFormattedFromAssociativeArray(): void
    {
        $serie = PieSerie::new()->data(['Email' => 335, 'Direct' => 310]);
        $data = $serie->toArray()['data'];

        $this->assertSame([
            ['name' => 'Email', 'value' => 335],
            ['name' => 'Direct', 'value' => 310],
        ], $data);
    }

    public function testDataWithFloatValues(): void
    {
        $serie = PieSerie::new()->data(['A' => 33.5, 'B' => 66.5]);
        $data = $serie->toArray()['data'];

        $this->assertSame(33.5, $data[0]['value']);
    }

    public function testRadius(): void
    {
        $serie = PieSerie::new()->radius('40%', '70%');
        $this->assertSame(['40%', '70%'], $serie->toArray()['radius']);
    }

    public function testRadiusDefaultOuter(): void
    {
        $serie = PieSerie::new()->radius('0%');
        $this->assertSame(['0%', '70%'], $serie->toArray()['radius']);
    }

    public function testCenter(): void
    {
        $serie = PieSerie::new()->center('50%', '60%');
        $this->assertSame(['50%', '60%'], $serie->toArray()['center']);
    }

    public function testRoseType(): void
    {
        $this->assertSame('area', PieSerie::new()->roseType()->toArray()['roseType']);
    }

    public function testRoseTypeCustom(): void
    {
        $this->assertSame('radius', PieSerie::new()->roseType('radius')->toArray()['roseType']);
    }
}
