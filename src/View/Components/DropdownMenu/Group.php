<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DropdownMenu;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Group extends StencilComponent
{
    public function __construct(
        public mixed $heading = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.dropdown-menu.group';
    }
}
