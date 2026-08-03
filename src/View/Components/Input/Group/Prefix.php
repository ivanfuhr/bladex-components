<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Input\Group;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Prefix extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.input.group.prefix';
    }
}
