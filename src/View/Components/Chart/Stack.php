<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Stack extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.chart.stack';
    }
}
