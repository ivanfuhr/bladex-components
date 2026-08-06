<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Avatar;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Group extends StdComponent
{
    public function __construct(
        public mixed $label = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.avatar.group';
    }
}
