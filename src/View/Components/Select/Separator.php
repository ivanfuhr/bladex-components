<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Select;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Separator extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.select.separator';
    }
}
