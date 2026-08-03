<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class EmptyState extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.empty.index';
    }
}
