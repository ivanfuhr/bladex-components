<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Alert;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Title extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.alert.title';
    }
}
