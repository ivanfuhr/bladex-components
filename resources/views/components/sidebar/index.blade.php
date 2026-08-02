@props([
    'side' => 'left',
    'variant' => 'sidebar',
    'collapsible' => 'offcanvas',
])

@php
    $resolvedSide = in_array($side, ['left', 'right'], true) ? $side : 'left';
    $resolvedVariant = in_array($variant, ['sidebar', 'floating', 'inset'], true) ? $variant : 'sidebar';
    $resolvedCollapsible = in_array($collapsible, ['offcanvas', 'icon', 'none'], true) ? $collapsible : 'offcanvas';
    $isNonCollapsible = $resolvedCollapsible === 'none';
    $isFloatingOrInset = $resolvedVariant === 'floating' || $resolvedVariant === 'inset';
    $label = $attributes->get('aria-label', 'Sidebar');
@endphp

@if ($isNonCollapsible)
    <aside {{
        $attributes->except('aria-label')->class([
            'sidebar',
            'flex h-full w-[var(--stencil-sidebar-width)] flex-col border-r border-zinc-200 bg-zinc-50 text-zinc-700',
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
            'group peer text-zinc-700 dark:text-zinc-100',
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
                'relative hidden bg-transparent transition-[width] duration-200 ease-out motion-reduce:transition-none md:block',
                'w-[var(--stencil-sidebar-width)]',
                'group-data-[collapsible=offcanvas]:w-0',
                'group-data-[side=right]:rotate-180',
                $isFloatingOrInset
                    ? 'group-data-[collapsible=icon]:w-[calc(var(--stencil-sidebar-width-icon)+1rem)]'
                    : 'group-data-[collapsible=icon]:w-[var(--stencil-sidebar-width-icon)]',
            ])
        ></div>

        <div
            data-sidebar-container
            @class([
                'fixed inset-y-0 z-30 flex h-svh transition-[left,right,width,transform] duration-200 ease-out motion-reduce:transition-none',
                // Mobile: off-canvas sheet
                'pointer-events-none w-[var(--stencil-sidebar-width-mobile)] group-data-[mobile-open=true]:pointer-events-auto',
                $resolvedSide === 'left' ? 'left-0' : 'right-0',
                $resolvedSide === 'left'
                    ? '-translate-x-full group-data-[mobile-open=true]:translate-x-0'
                    : 'translate-x-full group-data-[mobile-open=true]:translate-x-0',
                // Desktop: layout gap + fixed panel
                'md:pointer-events-auto md:w-[var(--stencil-sidebar-width)] md:translate-x-0',
                $resolvedSide === 'left'
                    ? 'md:group-data-[collapsible=offcanvas]:left-[calc(var(--stencil-sidebar-width)*-1)]'
                    : 'md:group-data-[collapsible=offcanvas]:right-[calc(var(--stencil-sidebar-width)*-1)]',
                $isFloatingOrInset
                    ? 'md:p-2 md:group-data-[collapsible=icon]:w-[calc(var(--stencil-sidebar-width-icon)+1rem+2px)]'
                    : 'md:group-data-[collapsible=icon]:w-[var(--stencil-sidebar-width-icon)] md:group-data-[side=left]:border-r md:group-data-[side=right]:border-l md:group-data-[side=left]:border-zinc-200 md:group-data-[side=right]:border-zinc-200 dark:md:group-data-[side=left]:border-zinc-800 dark:md:group-data-[side=right]:border-zinc-800',
            ])
        >
            <div
                data-sidebar-inner
                class="flex h-full w-full flex-col bg-zinc-50 text-zinc-700 group-data-[variant=floating]:rounded-lg group-data-[variant=floating]:border group-data-[variant=floating]:border-zinc-200 group-data-[variant=floating]:shadow-sm dark:bg-zinc-900 dark:text-zinc-100 dark:group-data-[variant=floating]:border-zinc-800"
                role="navigation"
                aria-label="{{ $label }}"
            >
                {{ $slot }}
            </div>
        </div>

        <x-stencil::sidebar.backdrop />
    </div>
@endif
