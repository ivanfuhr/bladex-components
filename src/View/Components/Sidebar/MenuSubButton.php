<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class MenuSubButton extends StencilComponent
{
    public function __construct(
        public mixed $href = null,
        public bool $active = false,
        public mixed $size = 'md',
        public bool $asChild = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.menu-sub-button';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $useLink = filled($this->href);
        $tag = $useLink ? 'a' : 'button';
        $sizeClasses = $this->size === 'sm' ? 'text-xs' : 'text-sm';

        $classes = [
            'sidebar__menu-sub-button',
            'flex h-7 min-w-0 -translate-x-px items-center gap-2 overflow-hidden rounded-md px-2 outline-none',
            'text-zinc-700 ring-zinc-950/10 hover:bg-zinc-100 hover:text-zinc-950 focus-visible:ring-2',
            'active:bg-zinc-100 active:text-zinc-950 disabled:pointer-events-none disabled:opacity-50',
            'data-[active=true]:bg-zinc-900 data-[active=true]:font-medium data-[active=true]:text-zinc-50',
            'data-[active=true]:hover:bg-zinc-800 data-[active=true]:hover:text-zinc-50',
            'dark:text-zinc-200 dark:ring-zinc-300/20 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            'dark:active:bg-zinc-800 dark:data-[active=true]:bg-zinc-100 dark:data-[active=true]:text-zinc-900',
            'dark:data-[active=true]:hover:bg-zinc-200 dark:data-[active=true]:hover:text-zinc-900',
            '[&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0',
            'group-data-[collapsible=icon]:hidden',
            $sizeClasses,
        ];

        return [
            'isActive' => $this->active,
            'useLink' => $useLink,
            'tag' => $tag,
            'classes' => $classes,
        ];
    }
}
