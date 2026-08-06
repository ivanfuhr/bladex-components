<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Select;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Group extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.select.group';
    }
}
