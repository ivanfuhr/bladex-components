<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DatetimePicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Footer extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.datetime-picker.footer';
    }
}
