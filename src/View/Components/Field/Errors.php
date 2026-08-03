<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Field;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Errors extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.field.errors';
    }
}
