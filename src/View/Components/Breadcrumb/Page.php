<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Breadcrumb;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Page extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.breadcrumb.page';
    }
}
