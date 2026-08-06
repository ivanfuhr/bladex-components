<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Tabs;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Provider extends StdComponent
{
    public function __construct(
        public mixed $tabsId = null,
        public mixed $defaultValue = null,
        public mixed $variant = 'default',
        public mixed $orientation = 'horizontal',
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.tabs.provider';
    }
}
