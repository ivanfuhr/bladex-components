<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Chart\Axis;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Grid extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.chart.axis.grid';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'axis' => $this->aware('axis', 'x'),
        ];
    }
}
