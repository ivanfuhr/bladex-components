<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Pagination;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Link extends StdComponent
{
    public function __construct(
        public mixed $href = '#',
        public bool $isActive = false,
        public bool $disabled = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.pagination.link';
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
