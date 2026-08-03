<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Button;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Group extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.button.group.index';
    }
}
