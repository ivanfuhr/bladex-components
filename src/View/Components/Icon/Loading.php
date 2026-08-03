<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Icon;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Loading extends StencilComponent
{
    public function __construct(
        public mixed $variant = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.icon.loading';
    }
}
