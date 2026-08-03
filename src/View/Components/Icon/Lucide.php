<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Icon;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Lucide extends StencilComponent
{
    public function __construct(
        public mixed $variant = 'outline',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.icon.lucide';
    }
}
