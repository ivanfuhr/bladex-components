<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Dialog;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Trigger extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.dialog.trigger';
    }
}
