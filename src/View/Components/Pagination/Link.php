<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Pagination;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Link extends StencilComponent
{
    public function __construct(
        public mixed $href = '#',
        public bool $isActive = false,
        public bool $disabled = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.pagination.link';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isDisabled = $this->disabled;

        return [
            'isDisabled' => $isDisabled,
            'tag' => $isDisabled ? 'span' : 'a',
        ];
    }
}
