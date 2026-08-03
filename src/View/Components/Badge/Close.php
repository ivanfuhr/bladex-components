<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Badge;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Close extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.badge.close';
    }
}
