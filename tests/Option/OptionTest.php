<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Option;

use HechtA\UX\ECharts\Option\Option;
use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
    public function testConstructorWithEmptyData(): void
    {
        $option = new Option();

        $this->assertSame([], $option->toArray());
    }

    public function testConstructorWithData(): void
    {
        $option = new Option(['color' => '#fff', 'show' => true]);

        $this->assertSame(['color' => '#fff', 'show' => true], $option->toArray());
    }

    public function testSetStoresScalarValue(): void
    {
        $option = new Option();
        $option->set('color', '#fff');

        $this->assertSame('#fff', $option->toArray()['color']);
    }

    public function testSetFlattensNestedOption(): void
    {
        $nested = new Option(['size' => 14]);
        $option = new Option();
        $option->set('label', $nested);

        $this->assertSame(['size' => 14], $option->toArray()['label']);
    }

    public function testSetOverwritesExistingKey(): void
    {
        $option = new Option(['color' => 'red']);
        $option->set('color', 'blue');

        $this->assertSame('blue', $option->toArray()['color']);
    }

    public function testSetIsChainable(): void
    {
        $option = new Option();
        $result = $option->set('a', 1)->set('b', 2);

        $this->assertSame($option, $result);
        $this->assertSame(['a' => 1, 'b' => 2], $option->toArray());
    }
}
