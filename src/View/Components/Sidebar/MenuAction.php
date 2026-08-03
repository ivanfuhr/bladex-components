<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class MenuAction extends StencilComponent
{
    public function __construct(
        public bool $asChild = false,
        public bool $showOnHover = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.menu-action';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'classes' => [
                'sidebar__menu-action',
                'absolute top-1.5 right-1 flex aspect-square size-5 items-center justify-center rounded-md p-0 text-zinc-500 outline-none',
                'ring-zinc-950/10 transition-transform peer-hover/menu-button:text-zinc-950 hover:bg-zinc-100 hover:text-zinc-950 focus-visible:ring-2',
                'dark:text-zinc-400 dark:ring-zinc-300/20 dark:peer-hover/menu-button:text-zinc-50 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
                '[&>svg]:size-4 [&>svg]:shrink-0',
                'after:absolute after:-inset-2 md:after:hidden',
                'peer-data-[size=sm]/menu-button:top-1',
                'peer-data-[size=default]/menu-button:top-1.5',
                'peer-data-[size=lg]/menu-button:top-2.5',
                'group-data-[collapsible=icon]:hidden',
                $this->showOnHover
                    ? 'group-focus-within/menu-item:opacity-100 group-hover/menu-item:opacity-100 peer-data-[active=true]/menu-button:text-zinc-950 md:opacity-0 dark:peer-data-[active=true]/menu-button:text-zinc-50'
                    : null,
            ],
        ];
    }
}
