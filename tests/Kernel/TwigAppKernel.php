<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Tests\Kernel;

use HechtA\UX\ECharts\EChartsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\UX\StimulusBundle\StimulusBundle;

class TwigAppKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return [new FrameworkBundle(), new TwigBundle(), new StimulusBundle(), new EChartsBundle()];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('framework', ['secret' => '$ecret', 'test' => true, 'http_method_override' => false]);
            $container->loadFromExtension('twig', ['default_path' => __DIR__ . '/templates', 'strict_variables' => true]);

            $container->setAlias('test.echarts.builder', 'echarts.builder')->setPublic(true);
            $container->setAlias('test.echarts.twig_extension', 'echarts.twig_extension')->setPublic(true);
        });
    }
}
