<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart\Axis;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Line extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.chart.axis.line';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'axis' => $this->aware('axis', 'x'),
        ];
    }
}
