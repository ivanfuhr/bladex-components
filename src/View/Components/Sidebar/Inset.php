<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Inset extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.inset';
    }
}
