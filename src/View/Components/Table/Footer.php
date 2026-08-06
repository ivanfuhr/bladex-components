<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Table;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Footer extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.table.footer';
    }
}
