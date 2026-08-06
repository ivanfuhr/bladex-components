<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Table;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Cell extends StdComponent
{
    public function __construct(
        public mixed $variant = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.table.cell';
    }
}
