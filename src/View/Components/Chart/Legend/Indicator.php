<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart\Legend;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Indicator extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.chart.legend.indicator';
    }
}
