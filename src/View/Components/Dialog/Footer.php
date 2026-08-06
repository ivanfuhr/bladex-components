<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Dialog;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Footer extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.dialog.footer';
    }
}
