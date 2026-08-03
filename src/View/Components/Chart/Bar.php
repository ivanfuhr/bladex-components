<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Bar extends StencilComponent
{
    public function __construct(
        public mixed $field = null,
        public mixed $minHeight = null,
        public mixed $radius = null,
        public mixed $width = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.chart.bar';
    }
}
