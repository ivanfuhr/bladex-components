<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Dialog extends StdComponent
{
    public function __construct(
        public mixed $name = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.dialog.index';
    }
}
