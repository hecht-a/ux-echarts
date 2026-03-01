<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Twig;

use HechtA\UX\ECharts\Model\ECharts;
use Symfony\UX\StimulusBundle\Helper\StimulusHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ChartExtension extends AbstractExtension
{
    public function __construct(
        private readonly StimulusHelper $stimulus,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_echarts', $this->renderECharts(...), ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param array<string, string|bool|int|float> $attributes
     */
    public function renderECharts(ECharts $chart, array $attributes = []): string
    {
        $chart->setAttributes(array_merge($chart->getAttributes(), $attributes));

        $controllers = [];
        if ($chart->getDataController()) {
            $controllers[$chart->getDataController()] = [];
        }
        $controllers['@hecht-a/ux-echarts/echarts'] = ['view' => $chart->createView()];

        $stimulusAttributes = $this->stimulus->createStimulusAttributes();
        foreach ($controllers as $name => $controllerValues) {
            $stimulusAttributes->addController($name, $controllerValues);
        }

        foreach ($chart->getAttributes() as $name => $value) {
            if ('data-controller' === $name) {
                continue;
            }

            if (true === $value) {
                $stimulusAttributes->addAttribute($name, $name);
            } elseif (false !== $value) {
                $stimulusAttributes->addAttribute($name, (string) $value);
            }
        }

        $width = $chart->isResizable() ? '100%' : $chart->getWidth() . 'px';
        $height = $chart->getHeight() . 'px';

        return \sprintf('<div style="width: %s; height: %s" %s></div>', $width, $height, $stimulusAttributes);
    }
}
