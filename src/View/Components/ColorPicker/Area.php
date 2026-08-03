<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ColorPicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Area extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.color-picker.area';
    }
}
