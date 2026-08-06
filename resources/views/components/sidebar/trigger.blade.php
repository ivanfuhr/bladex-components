@if ($asChild)
    <div {{
        $attributes->class(['sidebar__trigger', 'contents'])->merge([
            'data-sidebar-trigger' => true,
        ])
    }}>
        {{ $slot }}
    </div>
@else
    <button
        type="button"
        {{
            $attributes->class([
                'sidebar__trigger',
                'inline-flex size-11 shrink-0 items-center justify-center rounded-md text-zinc-700',
                '-ms-1 transition-colors hover:bg-zinc-100 hover:text-zinc-950',
                'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
                'dark:text-zinc-200 dark:hover:bg-zinc-800 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20',
            ])->merge([
                'data-sidebar-trigger' => true,
                'aria-expanded' => $isExpanded ? 'true' : 'false',
                'aria-label' => $attributes->get('aria-label', 'Toggle sidebar'),
            ])
        }}
    >
        @if ($slot->isEmpty())
            <x-std::icon name="panel-left" class="size-4 rtl:rotate-180" />
            <span class="sr-only">Toggle sidebar</span>
        @else
            {{ $slot }}
        @endif
    </button>
@endif
