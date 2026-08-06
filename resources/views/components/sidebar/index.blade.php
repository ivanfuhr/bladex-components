@if ($isNonCollapsible)
    <aside {{
        $attributes->except('aria-label')->class([
            'sidebar',
            'flex h-full w-[var(--std-sidebar-width)] flex-col border-r border-zinc-200 bg-zinc-50 text-zinc-700',
            'dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-100',
        ])->merge([
            'data-sidebar' => true,
            'data-sidebar-root' => true,
            'data-side' => $resolvedSide,
            'data-variant' => $resolvedVariant,
            'data-collapsible-mode' => 'none',
            'data-state' => 'expanded',
            'aria-label' => $label,
        ])
    }}>
        {{ $slot }}
    </aside>
@else
    <div {{
        $attributes->except('aria-label')->class([
            'sidebar',
            'group peer shrink-0 self-stretch min-h-full text-zinc-700 dark:text-zinc-100',
        ])->merge([
            'data-sidebar' => true,
            'data-sidebar-root' => true,
            'data-side' => $resolvedSide,
            'data-variant' => $resolvedVariant,
            'data-collapsible-mode' => $resolvedCollapsible,
            'data-collapsible' => '',
            'data-state' => 'expanded',
            'data-mobile' => 'false',
            'data-mobile-open' => 'false',
        ])
    }}>
        {{-- Desktop layout spacer (hidden on mobile). --}}
        <div
            data-sidebar-gap
            @class([
                'relative hidden self-stretch bg-transparent transition-[width] duration-200 ease-out motion-reduce:transition-none md:block',
                'w-[var(--std-sidebar-width)]',
                'group-data-[collapsible=offcanvas]:w-0',
                'group-data-[side=right]:rotate-180',
                $isFloatingOrInset
                    ? 'group-data-[collapsible=icon]:w-[calc(var(--std-sidebar-width-icon)+1rem)]'
                    : 'group-data-[collapsible=icon]:w-[var(--std-sidebar-width-icon)]',
            ])
        ></div>

        <div
            data-sidebar-container
            @class([
                'fixed inset-y-0 z-30 flex h-svh transition-[left,right,width,transform] duration-200 ease-out motion-reduce:transition-none',
                'md:absolute md:h-full',
                // Mobile: off-canvas sheet
                'pointer-events-none w-[var(--std-sidebar-width-mobile)] group-data-[mobile-open=true]:pointer-events-auto',
                $resolvedSide === 'left' ? 'left-0' : 'right-0',
                $resolvedSide === 'left'
                    ? '-translate-x-full group-data-[mobile-open=true]:translate-x-0'
                    : 'translate-x-full group-data-[mobile-open=true]:translate-x-0',
                // Desktop: layout gap + fixed panel
                'md:pointer-events-auto md:w-[var(--std-sidebar-width)] md:translate-x-0',
                $resolvedSide === 'left'
                    ? 'md:group-data-[collapsible=offcanvas]:left-[calc(var(--std-sidebar-width)*-1)]'
                    : 'md:group-data-[collapsible=offcanvas]:right-[calc(var(--std-sidebar-width)*-1)]',
                $isFloatingOrInset
                    ? 'md:p-2 md:group-data-[collapsible=icon]:w-[calc(var(--std-sidebar-width-icon)+1rem+2px)]'
                    : 'md:group-data-[collapsible=icon]:w-[var(--std-sidebar-width-icon)] md:group-data-[side=left]:border-r md:group-data-[side=right]:border-l md:group-data-[side=left]:border-zinc-200 md:group-data-[side=right]:border-zinc-200 dark:md:group-data-[side=left]:border-zinc-800 dark:md:group-data-[side=right]:border-zinc-800',
            ])
        >
            <div
                data-sidebar-inner
                class="flex h-full min-h-0 w-full flex-col overflow-hidden bg-zinc-50 text-zinc-700 shadow-sm group-data-[variant=floating]:rounded-lg group-data-[variant=floating]:border group-data-[variant=floating]:border-zinc-200 group-data-[variant=floating]:shadow-sm dark:bg-zinc-900 dark:text-zinc-100 dark:group-data-[variant=floating]:border-zinc-800"
                role="navigation"
                aria-label="{{ $label }}"
            >
                {{ $slot }}
            </div>
        </div>

        <x-std::sidebar.backdrop />
    </div>
@endif
