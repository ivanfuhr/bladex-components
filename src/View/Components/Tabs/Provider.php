<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Tabs;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Provider extends StencilComponent
{
    public function __construct(
        public mixed $tabsId = null,
        public mixed $defaultValue = null,
        public mixed $variant = 'default',
        public mixed $orientation = 'horizontal',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.tabs.provider';
    }
}
