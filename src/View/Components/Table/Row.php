<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Table;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Row extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.table.row';
    }
}
