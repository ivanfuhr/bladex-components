<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class MenuBadge extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.menu-badge';
    }
}
