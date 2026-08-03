<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ButtonGroup;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Text extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.button-group.text';
    }
}
