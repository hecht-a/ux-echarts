<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Option;

use HechtA\UX\ECharts\Model\ECharts;
use HechtA\UX\ECharts\Option\Toolbox;
use PHPUnit\Framework\TestCase;

class ToolboxTest extends TestCase
{
    public function testDefaultConstructorIsVisible(): void
    {
        $toolbox = new Toolbox();

        $this->assertTrue($toolbox->toArray()['show']);
        $this->assertSame([], $toolbox->toArray()['feature']);
    }

    public function testDefaultIncludesSaveAsImage(): void
    {
        $this->assertArrayHasKey('saveAsImage', Toolbox::default()->toArray()['feature']);
    }

    public function testDefaultIncludesDataView(): void
    {
        $this->assertArrayHasKey('dataView', Toolbox::default()->toArray()['feature']);
    }

    public function testDefaultIncludesRestore(): void
    {
        $this->assertArrayHasKey('restore', Toolbox::default()->toArray()['feature']);
    }

    public function testDefaultDoesNotIncludeDataZoom(): void
    {
        $this->assertArrayNotHasKey('dataZoom', Toolbox::default()->toArray()['feature']);
    }

    public function testDefaultDoesNotIncludeMagicType(): void
    {
        $this->assertArrayNotHasKey('magicType', Toolbox::default()->toArray()['feature']);
    }

    public function testSaveAsImageDefaultIsPng(): void
    {
        $toolbox = (new Toolbox())->saveAsImage();

        $this->assertSame('png', $toolbox->toArray()['feature']['saveAsImage']['type']);
    }

    public function testSaveAsImageSvg(): void
    {
        $toolbox = (new Toolbox())->saveAsImage('svg');

        $this->assertSame('svg', $toolbox->toArray()['feature']['saveAsImage']['type']);
    }

    public function testSaveAsImageCustomTitle(): void
    {
        $toolbox = (new Toolbox())->saveAsImage('png', 'Export PNG');

        $this->assertSame('Export PNG', $toolbox->toArray()['feature']['saveAsImage']['title']);
    }

    public function testDataViewDefaultIsNotReadOnly(): void
    {
        $toolbox = (new Toolbox())->dataView();

        $this->assertFalse($toolbox->toArray()['feature']['dataView']['readOnly']);
    }

    public function testDataViewReadOnly(): void
    {
        $toolbox = (new Toolbox())->dataView(readOnly: true);

        $this->assertTrue($toolbox->toArray()['feature']['dataView']['readOnly']);
    }

    public function testDataViewIsVisible(): void
    {
        $toolbox = (new Toolbox())->dataView();

        $this->assertTrue($toolbox->toArray()['feature']['dataView']['show']);
    }

    public function testRestoreIsVisible(): void
    {
        $toolbox = (new Toolbox())->restore();

        $this->assertTrue($toolbox->toArray()['feature']['restore']['show']);
    }

    public function testRestoreCustomTitle(): void
    {
        $toolbox = (new Toolbox())->restore('Reset');

        $this->assertSame('Reset', $toolbox->toArray()['feature']['restore']['title']);
    }

    public function testDataZoomIsVisible(): void
    {
        $toolbox = (new Toolbox())->dataZoom();

        $this->assertTrue($toolbox->toArray()['feature']['dataZoom']['show']);
    }

    public function testMagicTypeDefaultTypes(): void
    {
        $toolbox = (new Toolbox())->magicType();

        $this->assertSame(['line', 'bar'], $toolbox->toArray()['feature']['magicType']['type']);
    }

    public function testMagicTypeCustomTypes(): void
    {
        $toolbox = (new Toolbox())->magicType(['line', 'bar', 'stack']);

        $this->assertSame(['line', 'bar', 'stack'], $toolbox->toArray()['feature']['magicType']['type']);
    }

    public function testShow(): void
    {
        $this->assertFalse((new Toolbox())->show(false)->toArray()['show']);
    }

    public function testLeft(): void
    {
        $this->assertSame('right', (new Toolbox())->left('right')->toArray()['left']);
    }

    public function testTop(): void
    {
        $this->assertSame('top', (new Toolbox())->top('top')->toArray()['top']);
    }

    public function testFullChain(): void
    {
        $toolbox = (new Toolbox())
            ->saveAsImage('svg', 'Export')
            ->dataView(readOnly: true)
            ->restore()
            ->dataZoom()
            ->magicType(['line', 'bar'])
            ->left('right')
            ->top('top');

        $array = $toolbox->toArray();

        $this->assertSame('svg', $array['feature']['saveAsImage']['type']);
        $this->assertTrue($array['feature']['dataView']['readOnly']);
        $this->assertTrue($array['feature']['restore']['show']);
        $this->assertTrue($array['feature']['dataZoom']['show']);
        $this->assertSame(['line', 'bar'], $array['feature']['magicType']['type']);
        $this->assertSame('right', $array['left']);
        $this->assertSame('top', $array['top']);
    }

    public function testExportableWithoutArgumentUsesDefault(): void
    {
        $chart = new ECharts();
        $chart->exportable();

        $toolbox = $chart->getOptions()['toolbox'];
        $this->assertArrayHasKey('saveAsImage', $toolbox['feature']);
        $this->assertArrayHasKey('dataView', $toolbox['feature']);
        $this->assertArrayHasKey('restore', $toolbox['feature']);
    }

    public function testExportableWithCustomToolbox(): void
    {
        $chart = new ECharts();
        $chart->exportable((new Toolbox())->saveAsImage('svg')->magicType());

        $toolbox = $chart->getOptions()['toolbox'];
        $this->assertSame('svg', $toolbox['feature']['saveAsImage']['type']);
        $this->assertArrayHasKey('magicType', $toolbox['feature']);
        $this->assertArrayNotHasKey('restore', $toolbox['feature']);
    }
}
