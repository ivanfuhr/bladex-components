<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Collapse extends StencilComponent
{
    public function __construct(
        public bool $asChild = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.collapse';
    }
}
