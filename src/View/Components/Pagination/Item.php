<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Pagination;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Item extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.pagination.item';
    }
}
