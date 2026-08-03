<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DropdownMenu;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Trigger extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.dropdown-menu.trigger';
    }
}
