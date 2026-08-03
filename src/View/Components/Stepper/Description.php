<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Stepper;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Description extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.stepper.description';
    }
}
