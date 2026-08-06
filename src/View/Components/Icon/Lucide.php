<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Icon;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Lucide extends StdComponent
{
    public function __construct(
        public mixed $variant = 'outline',
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.icon.lucide';
    }
}
