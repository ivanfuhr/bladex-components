<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart\Axis;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Grid extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.chart.axis.grid';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'axis' => $this->aware('axis', 'x'),
        ];
    }
}
