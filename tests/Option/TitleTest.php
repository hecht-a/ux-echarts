<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Option;

use HechtA\UX\ECharts\Option\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    public function testDefaultConstructorIsEmpty(): void
    {
        $this->assertSame([], (new Title())->toArray());
    }

    public function testConstructorSetsText(): void
    {
        $this->assertSame(['text' => 'My chart'], (new Title('My chart'))->toArray());
    }

    public function testText(): void
    {
        $this->assertSame('Revenue', (new Title())->text('Revenue')->toArray()['text']);
    }

    public function testLink(): void
    {
        $this->assertSame('https://example.com', (new Title())->link('https://example.com')->toArray()['link']);
    }

    public function testTarget(): void
    {
        $this->assertSame('blank', (new Title())->target('blank')->toArray()['target']);
    }

    public function testSubtext(): void
    {
        $this->assertSame('Subtitle', (new Title())->subtext('Subtitle')->toArray()['subtext']);
    }

    public function testSublink(): void
    {
        $this->assertSame('https://sub.com', (new Title())->sublink('https://sub.com')->toArray()['sublink']);
    }

    public function testSubtarget(): void
    {
        $this->assertSame('self', (new Title())->subtarget('self')->toArray()['subtarget']);
    }

    public function testLeft(): void
    {
        $this->assertSame('center', (new Title())->left('center')->toArray()['left']);
    }

    public function testTop(): void
    {
        $this->assertSame('10%', (new Title())->top('10%')->toArray()['top']);
    }

    public function testRight(): void
    {
        $this->assertSame('auto', (new Title())->right('auto')->toArray()['right']);
    }

    public function testBottom(): void
    {
        $this->assertSame('5%', (new Title())->bottom('5%')->toArray()['bottom']);
    }

    public function testBackgroundColor(): void
    {
        $this->assertSame('#fff', (new Title())->backgroundColor('#fff')->toArray()['backgroundColor']);
    }

    public function testBorderColor(): void
    {
        $this->assertSame('#ccc', (new Title())->borderColor('#ccc')->toArray()['borderColor']);
    }

    public function testBorderWidth(): void
    {
        $this->assertSame(2, (new Title())->borderWidth(2)->toArray()['borderWidth']);
    }

    public function testBorderRadius(): void
    {
        $this->assertSame(4, (new Title())->borderRadius(4)->toArray()['borderRadius']);
    }

    public function testPaddingAsInt(): void
    {
        $this->assertSame(10, (new Title())->padding(10)->toArray()['padding']);
    }

    public function testPaddingAsArray(): void
    {
        $this->assertSame([5, 10, 5, 10], (new Title())->padding([5, 10, 5, 10])->toArray()['padding']);
    }

    public function testItemGap(): void
    {
        $this->assertSame(8, (new Title())->itemGap(8)->toArray()['itemGap']);
    }

    public function testZlevel(): void
    {
        $this->assertSame(2, (new Title())->zlevel(2)->toArray()['zlevel']);
    }

    public function testZ(): void
    {
        $this->assertSame(3, (new Title())->z(3)->toArray()['z']);
    }

    public function testShow(): void
    {
        $this->assertTrue((new Title())->show()->toArray()['show']);
        $this->assertFalse((new Title())->show(false)->toArray()['show']);
    }

    public function testTextStyle(): void
    {
        $style = ['color' => '#333', 'fontSize' => 18];
        $this->assertSame($style, (new Title())->textStyle($style)->toArray()['textStyle']);
    }

    public function testSubtextStyle(): void
    {
        $style = ['color' => '#aaa', 'fontSize' => 12];
        $this->assertSame($style, (new Title())->subtextStyle($style)->toArray()['subtextStyle']);
    }

    public function testFullChain(): void
    {
        $title = (new Title('Revenue'))
            ->subtext('2026')
            ->left('center')
            ->top('5%')
            ->backgroundColor('#f8f8f8')
            ->borderWidth(1)
            ->padding(10)
            ->itemGap(5);

        $array = $title->toArray();
        $this->assertSame('Revenue', $array['text']);
        $this->assertSame('2026', $array['subtext']);
        $this->assertSame('center', $array['left']);
        $this->assertSame('5%', $array['top']);
        $this->assertSame('#f8f8f8', $array['backgroundColor']);
        $this->assertSame(1, $array['borderWidth']);
        $this->assertSame(10, $array['padding']);
        $this->assertSame(5, $array['itemGap']);
    }
}
