<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Sidebar;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Collapse extends StdComponent
{
    public function __construct(
        public bool $asChild = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.sidebar.collapse';
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
