<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Sidebar;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class GroupAction extends StdComponent
{
    public function __construct(
        public bool $asChild = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.sidebar.group-action';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'classes' => [
                'sidebar__group-action',
                'absolute top-3.5 right-3 flex aspect-square size-5 items-center justify-center rounded-md p-0 text-zinc-500 outline-none',
                'ring-zinc-950/10 transition-transform hover:bg-zinc-100 hover:text-zinc-950 focus-visible:ring-2',
                'dark:text-zinc-400 dark:ring-zinc-300/20 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
                '[&>svg]:size-4 [&>svg]:shrink-0',
                'after:absolute after:-inset-2 md:after:hidden',
                'group-data-[collapsible=icon]:hidden',
            ],
        ];
    }
}
