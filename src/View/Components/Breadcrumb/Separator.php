<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Breadcrumb;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Separator extends StencilComponent
{
    public function __construct(
        public mixed $type = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.breadcrumb.separator';
    }
}
