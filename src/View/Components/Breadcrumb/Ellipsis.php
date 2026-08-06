<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Breadcrumb;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Ellipsis extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.breadcrumb.ellipsis';
    }
}
