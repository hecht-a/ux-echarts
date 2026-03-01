<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Serie;

use HechtA\UX\ECharts\Tests\Fixtures\ConcreteSerie;
use PHPUnit\Framework\TestCase;

class SerieTest extends TestCase
{
    public function testTypeIsSetFromConstructor(): void
    {
        $serie = new ConcreteSerie();
        $this->assertSame('custom', $serie->toArray()['type']);
    }

    public function testNameIsSetFromConstructor(): void
    {
        $serie = new ConcreteSerie('My serie');
        $this->assertSame('My serie', $serie->toArray()['name']);
    }

    public function testNameIsAbsentWhenNull(): void
    {
        $serie = new ConcreteSerie();
        $this->assertArrayNotHasKey('name', $serie->toArray());
    }

    public function testNameSetter(): void
    {
        $serie = (new ConcreteSerie())->name('Updated');
        $this->assertSame('Updated', $serie->toArray()['name']);
    }

    public function testDataSetter(): void
    {
        $serie = (new ConcreteSerie())->data([10, 20, 30]);
        $this->assertSame([10, 20, 30], $serie->toArray()['data']);
    }

    public function testSetStoresArbitraryKey(): void
    {
        $serie = (new ConcreteSerie())->set('color', '#f00');
        $this->assertSame('#f00', $serie->toArray()['color']);
    }

    public function testSetIsChainable(): void
    {
        $serie = (new ConcreteSerie())->set('a', 1)->set('b', 2);
        $this->assertSame(1, $serie->toArray()['a']);
        $this->assertSame(2, $serie->toArray()['b']);
    }
}
