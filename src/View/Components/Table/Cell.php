<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Table;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Cell extends StencilComponent
{
    public function __construct(
        public mixed $variant = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.table.cell';
    }
}
