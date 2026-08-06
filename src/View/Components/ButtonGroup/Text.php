<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\ButtonGroup;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Text extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.button-group.text';
    }
}
