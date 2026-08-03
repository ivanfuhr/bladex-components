<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\DropdownMenu;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Item extends StencilComponent
{
    public function __construct(
        public mixed $href = null,
        public mixed $variant = 'default',
        public bool $disabled = false,
        public bool $keepOpen = false,
        public mixed $kbd = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.dropdown-menu.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $useLink = filled($this->href);

        return [
            'useLink' => $useLink,
            'tag' => $useLink ? 'a' : 'button',
            'isDanger' => $this->variant === 'danger' || $this->variant === 'destructive',
            'isDisabled' => $this->disabled,
        ];
    }
}
