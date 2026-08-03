<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DatePicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class ManualInputs extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.date-picker.manual-inputs';
    }
}
