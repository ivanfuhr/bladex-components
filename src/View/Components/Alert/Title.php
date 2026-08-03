<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Alert;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Title extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.alert.title';
    }
}
