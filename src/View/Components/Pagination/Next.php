<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Pagination;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Next extends StencilComponent
{
    public function __construct(
        public mixed $href = null,
        public bool $disabled = false,
        public mixed $text = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.pagination.next';
    }
}
