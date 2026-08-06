<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class EmptyState extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.empty.index';
    }
}
