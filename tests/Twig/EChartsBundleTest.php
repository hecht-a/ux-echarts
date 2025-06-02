<?php

namespace HechtA\UX\ECharts\Tests\Twig;

use PHPUnit\Framework\TestCase;
use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\Model\ECharts;
use HechtA\UX\ECharts\Tests\Kernel\TwigAppKernel;
use HechtA\UX\ECharts\Twig\ChartExtension;

class EChartsBundleTest extends TestCase
{
    public function testRenderChart()
    {
        $kernel = new TwigAppKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer()->get('test.service_container');

        /** @var EChartsBuilderInterface $builder */
        $builder = $container->get('test.echarts.builder');

        $chart = $builder->createECharts(ECharts::TYPE_LINE);

        $chart
            ->addSerie([
                'data' => [150, 230, 224, 218, 135, 147, 260],
                'type' => 'line',
            ])
            ->setWidth(400)
            ->setHeight(200)
            ->setOptions([
                'xAxis' => [
                    'type' => 'category',
                    'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                ],
                'yAxis' => [
                    'type' => 'value',
                ]]);

        /** @var ChartExtension $twigExtension */
        $twigExtension = $container->get('test.echarts.twig_extension');

        $rendered = $twigExtension->renderECharts(
            $chart,
            ['data-controller' => 'echarts', 'class' => 'myclass']
        );

        $this->assertSame('<div style="width: 400px; height: 200px" data-controller="hecht-a--ux-echarts--echarts" data-hecht-a--ux-echarts--echarts-view-value="{&quot;options&quot;:{&quot;xAxis&quot;:{&quot;type&quot;:&quot;category&quot;,&quot;data&quot;:[&quot;Mon&quot;,&quot;Tue&quot;,&quot;Wed&quot;,&quot;Thu&quot;,&quot;Fri&quot;,&quot;Sat&quot;,&quot;Sun&quot;]},&quot;yAxis&quot;:{&quot;type&quot;:&quot;value&quot;},&quot;series&quot;:[{&quot;data&quot;:[150,230,224,218,135,147,260],&quot;type&quot;:&quot;line&quot;}]},&quot;attributes&quot;:{&quot;data-controller&quot;:&quot;echarts&quot;,&quot;class&quot;:&quot;myclass&quot;},&quot;themes&quot;:[],&quot;currentTheme&quot;:null}" class="myclass"></div>', $rendered);
    }
}
