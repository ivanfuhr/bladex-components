<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Popover;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Trigger extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.popover.trigger';
    }
}
