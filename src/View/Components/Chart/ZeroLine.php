<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class ZeroLine extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.chart.zero-line';
    }
}
