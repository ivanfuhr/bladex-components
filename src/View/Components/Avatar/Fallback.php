<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Avatar;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Fallback extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.avatar.fallback';
    }
}
