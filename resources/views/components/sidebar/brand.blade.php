@if ($useLink)
    <a
        href="{{ $href }}"
        {{
            $attributes->class($classes)->merge([
                'data-sidebar-brand' => true,
            ])
        }}
    >
        @if (isset($logo))
            <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-900 text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900">
                {{ $logo }}
            </span>
        @endif
        @if (filled($name))
            <span
                class="truncate text-sm font-semibold tracking-tight text-zinc-950 group-data-[collapsible=icon]:hidden dark:text-zinc-50"
            >
                {{ $name }}
            </span>
        @endif
        {{ $slot }}
    </a>
@else
    <div {{
        $attributes->class($classes)->merge([
            'data-sidebar-brand' => true,
        ])
    }}>
        @if (isset($logo))
            <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-zinc-900 text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900">
                {{ $logo }}
            </span>
        @endif
        @if (filled($name))
            <span
                class="truncate text-sm font-semibold tracking-tight text-zinc-950 group-data-[collapsible=icon]:hidden dark:text-zinc-50"
            >
                {{ $name }}
            </span>
        @endif
        {{ $slot }}
    </div>
@endif
