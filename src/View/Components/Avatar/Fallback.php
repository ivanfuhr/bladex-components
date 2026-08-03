<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Avatar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Fallback extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.avatar.fallback';
    }
}
