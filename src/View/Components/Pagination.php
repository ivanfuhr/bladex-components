<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class Pagination extends StencilComponent
{
    public function __construct(
        public mixed $paginator = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.pagination.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'hasPaginator' => $this->paginator instanceof LengthAwarePaginator,
        ];
    }
}
