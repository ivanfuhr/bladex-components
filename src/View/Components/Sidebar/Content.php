<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Sidebar;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    public function __construct(
        public string $type = 'hover',
        public int $scrollHideDelay = 600,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.sidebar.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $type = match ($this->type) {
            'always', 'scroll', 'auto', 'hover' => $this->type,
            default => 'hover',
        };

        $scrollHideDelay = max(0, $this->scrollHideDelay);

        $shellAttributes = $this->attributes
            ->only(['id', 'role'])
            ->merge($this->attributes->whereStartsWith('aria-')->getAttributes())
            ->class([
                'sidebar__content',
                'flex min-h-0 flex-1 flex-col overflow-hidden',
            ])
            ->merge([
                'data-sidebar-content' => true,
            ]);

        $bodyAttributes = $this->attributes
            ->except(['id', 'role'])
            ->whereDoesntStartWith('aria-')
            ->class([
                'flex flex-col gap-2',
            ]);

        return [
            'type' => $type,
            'scrollHideDelay' => $scrollHideDelay,
            'shellAttributes' => $shellAttributes,
            'bodyAttributes' => $bodyAttributes,
        ];
    }
}
