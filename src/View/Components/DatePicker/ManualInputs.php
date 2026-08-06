<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\DatePicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class ManualInputs extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.date-picker.manual-inputs';
    }
}
