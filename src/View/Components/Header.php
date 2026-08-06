<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Header extends StdComponent
{
    public function __construct(
        public mixed $variant = 'shell',
        public bool $sticky = false,
        public bool $border = true,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.header.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isPage = $this->variant === 'page';

        $classes = array_merge(
            [
                'app-header',
                'w-full shrink-0',
            ],
            $isPage
                ? [
                    'flex flex-col gap-4 md:flex-row md:items-start md:justify-between',
                ]
                : [
                    'flex h-16 items-center gap-2',
                    // Icon rail uses size-8 controls — shrink the shell band in lockstep.
                    'group-has-data-[collapsible=icon]/sidebar-wrapper:h-12',
                    'bg-white transition-[height] duration-200 ease-out motion-reduce:transition-none',
                    'dark:bg-zinc-950',
                ],
        );

        if ($this->border) {
            $classes[] = 'border-b border-zinc-200 dark:border-zinc-800';
        }

        if ($this->sticky) {
            $classes[] = 'sticky top-0 z-20';
        }

        return [
            'isPage' => $isPage,
            'classes' => $classes,
        ];
    }
}
