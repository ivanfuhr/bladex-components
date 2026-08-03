<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Breadcrumb;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Link extends StencilComponent
{
    public function __construct(
        public mixed $href = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.breadcrumb.link';
    }
}
