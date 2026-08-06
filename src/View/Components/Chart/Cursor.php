<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Chart;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Cursor extends StdComponent
{
    public function __construct(
        public mixed $type = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.chart.cursor';
    }
}
