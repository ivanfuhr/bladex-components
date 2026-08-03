<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Card;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Action extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.card.action';
    }
}
