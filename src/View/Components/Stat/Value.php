<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Stat;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Value extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.stat.value';
    }
}
