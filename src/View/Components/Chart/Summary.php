<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Summary extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.chart.summary.index';
    }
}
