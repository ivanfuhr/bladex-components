<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Field;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Description extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.field.description';
    }
}
