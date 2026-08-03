<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Table;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Head extends StencilComponent
{
    public function __construct(
        public bool $sortable = false,
        public bool $sorted = false,
        public mixed $direction = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.table.head';
    }
}
