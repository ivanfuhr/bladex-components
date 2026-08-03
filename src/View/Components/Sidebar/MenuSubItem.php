<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class MenuSubItem extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.menu-sub-item';
    }
}
