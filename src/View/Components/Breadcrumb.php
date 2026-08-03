<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Breadcrumb extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.breadcrumb.index';
    }
}
