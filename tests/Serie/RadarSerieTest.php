<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Serie;

use HechtA\UX\ECharts\Serie\RadarSerie;
use PHPUnit\Framework\TestCase;

class RadarSerieTest extends TestCase
{
    public function testTypeIsRadar(): void
    {
        $this->assertSame('radar', RadarSerie::new()->toArray()['type']);
    }

    public function testDataIsFormattedFromAssociativeArray(): void
    {
        $serie = RadarSerie::new()->data([
            'Team A' => [80, 90, 70],
            'Team B' => [60, 75, 85],
        ]);

        $this->assertSame([
            ['name' => 'Team A', 'value' => [80, 90, 70]],
            ['name' => 'Team B', 'value' => [60, 75, 85]],
        ], $serie->toArray()['data']);
    }

    public function testDataWithSingleSerie(): void
    {
        $serie = RadarSerie::new('Solo')->data(['Solo' => [100, 90, 80]]);
        $this->assertCount(1, $serie->toArray()['data']);
    }

    public function testStaticConstructorWithName(): void
    {
        $this->assertSame('Stats', RadarSerie::new('Stats')->toArray()['name']);
    }
}
