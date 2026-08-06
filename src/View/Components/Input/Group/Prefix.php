<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Input\Group;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Prefix extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.input.group.prefix';
    }
}
