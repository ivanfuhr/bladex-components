<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Pagination;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Previous extends StdComponent
{
    public function __construct(
        public mixed $href = null,
        public bool $disabled = false,
        public mixed $text = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.pagination.previous';
    }
}
