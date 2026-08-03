<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Toast;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Close extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.toast.close';
    }
}
