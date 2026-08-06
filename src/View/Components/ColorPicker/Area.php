<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\ColorPicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Area extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.color-picker.area';
    }
}
