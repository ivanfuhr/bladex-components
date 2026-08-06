<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Sidebar;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Menu extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.sidebar.menu';
    }
}
