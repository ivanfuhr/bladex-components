<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Stat;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Value extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.stat.value';
    }
}
