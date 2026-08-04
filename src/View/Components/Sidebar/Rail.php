<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Rail extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.rail';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'isExpanded' => (bool) $this->aware('defaultOpen', true),
        ];
    }
}
