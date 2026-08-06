<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Tooltip extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.chart.tooltip.index';
    }
}
