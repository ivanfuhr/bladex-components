<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class GroupLabel extends StencilComponent
{
    public function __construct(
        public bool $asChild = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.group-label';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'classes' => [
                'sidebar__group-label',
                'flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-semibold tracking-wide text-zinc-600 outline-none',
                'ring-zinc-950/10 transition-[margin,opacity] duration-200 ease-out focus-visible:ring-2',
                'dark:text-zinc-300 dark:ring-zinc-300/20',
                '[&>svg]:size-4 [&>svg]:shrink-0',
                'group-data-[collapsible=icon]:hidden',
            ],
        ];
    }
}
