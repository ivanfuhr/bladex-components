<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Tooltip extends StdComponent
{
    public function __construct(
        public mixed $side = 'top',
        public int $delay = 200,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.tooltip.index';
    }
}
