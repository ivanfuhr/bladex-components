<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Pagination;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Item extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.pagination.item';
    }
}
