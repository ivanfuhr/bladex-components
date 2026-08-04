<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Avatar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Group extends StencilComponent
{
    public function __construct(
        public mixed $label = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.avatar.group';
    }
}
