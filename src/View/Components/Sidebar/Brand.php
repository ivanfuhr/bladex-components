<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Sidebar;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Brand extends StencilComponent
{
    public function __construct(
        public mixed $href = '#',
        public mixed $name = null,
        public mixed $logo = null,
        public mixed $logoDark = null,
        public mixed $alt = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.sidebar.brand';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'useLink' => filled($this->href),
            'resolvedLogoDark' => $this->logoDark ?? $this->attributes->get('logo:dark'),
            'classes' => [
                'sidebar__brand',
                'flex min-w-0 flex-1 items-center gap-2 overflow-hidden rounded-md p-1.5 text-left outline-none',
                'ring-zinc-950/10 transition-[width,height,padding] duration-200 ease-out',
                'hover:bg-zinc-100 hover:text-zinc-950 focus-visible:ring-2',
                'dark:ring-zinc-300/20 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
                'group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:p-2!',
            ],
            'slotLogoWrapperClasses' => 'flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-900 text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900',
            'urlLogoWrapperClasses' => 'flex h-6 min-w-6 shrink-0 items-center justify-center overflow-hidden rounded-sm',
            'imageClasses' => 'h-6 min-w-6',
        ];
    }
}
