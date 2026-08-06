<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\DropdownMenu;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    public function __construct(
        public bool $keepOpen = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.dropdown-menu.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'align' => $this->aware('align', 'start'),
            'side' => $this->aware('side', 'bottom'),
        ];
    }
}
