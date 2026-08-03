<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart\Legend;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Indicator extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.chart.legend.indicator';
    }
}
