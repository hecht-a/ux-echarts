<?php

namespace Symfony\UX\ECharts\DependencyInjection;

use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\UX\ECharts\Builder\EChartsBuilder;
use Symfony\UX\ECharts\Builder\EChartsBuilderInterface;
use Symfony\UX\ECharts\Twig\ChartExtension;

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

        $container
            ->setDefinition('echarts.twig_extension', new Definition(ChartExtension::class))
            ->addArgument(new Reference('stimulus.helper'))
            ->addTag('twig.extension')
            ->setPublic(false)
        ;
    }
}