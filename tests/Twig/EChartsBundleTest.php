<?php

namespace Symfony\UX\ECharts\Tests\Twig;

use PHPUnit\Framework\TestCase;
use Symfony\UX\ECharts\Builder\EChartsBuilderInterface;
use Symfony\UX\ECharts\Model\ECharts;
use Symfony\UX\ECharts\Tests\Kernel\TwigAppKernel;
use Symfony\UX\ECharts\Twig\ChartExtension;

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
            ->setAttributes([
                'style' => 'width: 800px; height: 400px;',
            ])
            ->addSerie([
                'data' => [150, 230, 224, 218, 135, 147, 260],
                'type' => 'line',
            ])
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

        $this->assertSame('<div data-controller="symfony--ux-echarts--echarts" data-symfony--ux-echarts--echarts-view-value="{&quot;options&quot;:{&quot;xAxis&quot;:{&quot;type&quot;:&quot;category&quot;,&quot;data&quot;:[&quot;Mon&quot;,&quot;Tue&quot;,&quot;Wed&quot;,&quot;Thu&quot;,&quot;Fri&quot;,&quot;Sat&quot;,&quot;Sun&quot;]},&quot;yAxis&quot;:{&quot;type&quot;:&quot;value&quot;},&quot;series&quot;:[{&quot;data&quot;:[150,230,224,218,135,147,260],&quot;type&quot;:&quot;line&quot;}]},&quot;attributes&quot;:{&quot;style&quot;:&quot;width: 800px; height: 400px;&quot;,&quot;data-controller&quot;:&quot;echarts&quot;,&quot;class&quot;:&quot;myclass&quot;},&quot;themes&quot;:[],&quot;currentTheme&quot;:null}" style="width: 800px; height: 400px;" class="myclass"></div>', $rendered);
    }
}
