<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\DropdownMenu;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Label extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.dropdown-menu.label';
    }
}
