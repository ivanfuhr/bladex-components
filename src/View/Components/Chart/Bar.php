<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Bar extends StdComponent
{
    public function __construct(
        public mixed $field = null,
        public mixed $minHeight = null,
        public mixed $radius = null,
        public mixed $width = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.chart.bar';
    }
}
