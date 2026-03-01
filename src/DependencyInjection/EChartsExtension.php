<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\DependencyInjection;

use HechtA\UX\ECharts\Attribute\AsEChart;
use HechtA\UX\ECharts\Builder\EChartsBuilder;
use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\DataCollector\EChartsDataCollector;
use HechtA\UX\ECharts\Registry\EChartsRegistry;
use HechtA\UX\ECharts\Registry\EChartsRegistryInterface;
use HechtA\UX\ECharts\Resolver\EChartsValueResolver;
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

        $container
            ->setDefinition('echarts.registry', new Definition(EChartsRegistry::class))
            ->setPublic(false)
        ;
        $container
            ->setAlias(EChartsRegistryInterface::class, 'echarts.registry')
            ->setPublic(true)
        ;

        $container->registerAttributeForAutoconfiguration(
            AsEChart::class,
            static function (Definition $definition, AsEChart $attribute): void {
                $definition->addTag('echarts.chart', ['id' => $attribute->id]);
                $definition->setAutowired(true);
            }
        );

        $container
            ->setDefinition('echarts.value_resolver', new Definition(EChartsValueResolver::class))
            ->addArgument(new Reference('echarts.registry'))
            ->addTag('controller.argument_value_resolver', ['priority' => 50])
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

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('echarts.registry')) {
            return;
        }

        $registry = $container->getDefinition('echarts.registry');

        foreach ($container->findTaggedServiceIds('echarts.chart') as $id => $tags) {
            foreach ($tags as $tag) {
                $registry->addMethodCall('add', [$tag['id'], new Reference($id)]);
            }
        }
    }
}
