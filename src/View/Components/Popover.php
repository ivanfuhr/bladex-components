<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Popover extends StencilComponent
{
    public function __construct(
        public mixed $align = 'start',
        public mixed $side = 'bottom',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.popover.index';
    }
}
