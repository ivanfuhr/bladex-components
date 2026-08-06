<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Dialog;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Action extends StdComponent
{
    public function __construct(
        public mixed $variant = 'primary',
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.dialog.action';
    }
}
