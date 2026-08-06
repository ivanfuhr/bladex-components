<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\TimePicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Selected extends StdComponent
{
    public function __construct(
        public mixed $placeholder = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.time-picker.selected';
    }
}
