<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Table;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Head extends StdComponent
{
    public function __construct(
        public bool $sortable = false,
        public bool $sorted = false,
        public mixed $direction = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.table.head';
    }
}
