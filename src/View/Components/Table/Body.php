<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Table;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Body extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.table.body';
    }
}
