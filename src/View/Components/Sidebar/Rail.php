<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Sidebar;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Rail extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.sidebar.rail';
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
