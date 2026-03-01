<?php

declare(strict_types=1);

namespace HechtA\UX\ECharts\Resolver;

use HechtA\UX\ECharts\Chart\EchartsInterface;
use HechtA\UX\ECharts\Registry\EChartsRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

readonly class EChartsValueResolver implements ValueResolverInterface
{
    public function __construct(
        private EChartsRegistry $registry,
    ) {
    }

    /**
     * @return iterable<EchartsInterface>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();

        if ($type === null || !class_exists($type)) {
            return [];
        }

        if (!is_subclass_of($type, EchartsInterface::class)) {
            return [];
        }

        $chart = $this->registry->findByClass($type);

        if ($chart === null) {
            return [];
        }

        return [$chart];
    }
}
