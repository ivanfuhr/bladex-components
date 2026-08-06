<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Toast;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Close extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.toast.close';
    }
}
