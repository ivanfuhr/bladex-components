<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Stepper;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Label extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.stepper.label';
    }
}
