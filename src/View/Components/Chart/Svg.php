<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Svg extends StdComponent
{
    public function __construct(
        public mixed $gutter = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.chart.svg';
    }
}
