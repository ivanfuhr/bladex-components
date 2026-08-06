<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Icon;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Loading extends StdComponent
{
    public function __construct(
        public mixed $variant = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.icon.loading';
    }
}
