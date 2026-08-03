<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\TimePicker;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Selected extends StencilComponent
{
    public function __construct(
        public mixed $placeholder = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.time-picker.selected';
    }
}
