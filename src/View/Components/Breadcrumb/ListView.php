<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Breadcrumb;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class ListView extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.breadcrumb.list';
    }
}
