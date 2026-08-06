<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Empty;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.empty.content';
    }
}
