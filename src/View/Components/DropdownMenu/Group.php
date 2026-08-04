<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DropdownMenu;

use Illuminate\Support\Str;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Group extends StencilComponent
{
    public function __construct(
        public mixed $heading = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.dropdown-menu.group';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'headingId' => filled($this->heading)
                ? 'dropdown-menu-group-'.Str::uuid()->toString()
                : null,
        ];
    }
}
