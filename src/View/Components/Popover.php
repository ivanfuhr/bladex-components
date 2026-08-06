<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Popover extends StdComponent
{
    public function __construct(
        public mixed $align = 'start',
        public mixed $side = 'bottom',
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.popover.index';
    }
}
