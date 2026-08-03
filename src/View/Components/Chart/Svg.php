<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Svg extends StencilComponent
{
    public function __construct(
        public mixed $gutter = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.chart.svg';
    }
}
