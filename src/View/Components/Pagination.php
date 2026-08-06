<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class Pagination extends StdComponent
{
    public function __construct(
        public mixed $paginator = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.pagination.index';
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
