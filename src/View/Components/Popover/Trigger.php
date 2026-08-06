<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Popover;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Trigger extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.popover.trigger';
    }
}
