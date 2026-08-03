<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Dialog extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.dialog.index';
    }
}
