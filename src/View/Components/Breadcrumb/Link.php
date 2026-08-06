<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Breadcrumb;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Link extends StdComponent
{
    public function __construct(
        public mixed $href = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.breadcrumb.link';
    }
}
