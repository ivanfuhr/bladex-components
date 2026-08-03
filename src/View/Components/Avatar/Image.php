<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Avatar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Image extends StencilComponent
{
    public function __construct(
        public mixed $src = null,
        public mixed $alt = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.avatar.image';
    }
}
