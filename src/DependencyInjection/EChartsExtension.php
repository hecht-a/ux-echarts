<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\DependencyInjection;

use HechtA\UX\ECharts\Builder\EChartsBuilder;
use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\DataCollector\EChartsDataCollector;
use HechtA\UX\ECharts\Twig\ChartExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class EChartsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container
            ->setDefinition('echarts.builder', new Definition(EChartsBuilder::class))
            ->setPublic(false)
        ;

        $container
            ->setAlias(EChartsBuilderInterface::class, 'echarts.builder')
            ->setPublic(false)
        ;

        $collectorDefinition = new Definition(EChartsDataCollector::class);
        $collectorDefinition
            ->addTag('data_collector', [
                'template' => '@ECharts/collector/echarts.html.twig',
                'id' => 'echarts',
            ])
            ->setPublic(false)
        ;
        $container->setDefinition('echarts.data_collector', $collectorDefinition);
        $container->setAlias(EChartsDataCollector::class, 'echarts.data_collector')->setPublic(false);

        $container
            ->setDefinition('echarts.twig_extension', new Definition(ChartExtension::class))
            ->addArgument(new Reference('stimulus.helper'))
            ->addArgument(new Reference('echarts.data_collector'))
            ->addTag('twig.extension')
            ->setPublic(false)
        ;
    }
}
