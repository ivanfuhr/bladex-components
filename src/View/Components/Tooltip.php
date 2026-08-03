<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Tooltip extends StencilComponent
{
    public function __construct(
        public mixed $side = 'top',
        public int $delay = 200,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.tooltip.index';
    }
}
