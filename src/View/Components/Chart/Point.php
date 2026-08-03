<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Point extends StencilComponent
{
    public function __construct(
        public mixed $field = 'value',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.chart.point';
    }
}
